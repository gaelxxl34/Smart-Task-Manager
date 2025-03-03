<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct()
    {
        try {
            // Decode base64 credentials if available
            if ($firebaseCredentialsBase64 = env('FIREBASE_CREDENTIALS_BASE64')) {
                $firebaseCredentialsJson = base64_decode($firebaseCredentialsBase64);
                if (!$firebaseCredentialsJson) {
                    throw new \Exception('Failed to decode FIREBASE_CREDENTIALS_BASE64');
                }
                $serviceAccount = json_decode($firebaseCredentialsJson, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Failed to decode JSON: ' . json_last_error_msg());
                }
            } else {
                // Fallback to credentials file path
                $firebaseCredentialsPath = env('FIREBASE_CREDENTIALS');
                if (!$firebaseCredentialsPath || !file_exists($firebaseCredentialsPath)) {
                    throw new \Exception('Firebase credentials file path is not set or file does not exist');
                }
                $serviceAccount = $firebaseCredentialsPath;
            }

            // Initialize Firebase services
            $firebaseFactory = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $this->auth = $firebaseFactory->createAuth();
            $this->firestore = $firebaseFactory->createFirestore();

            Log::info('Firebase initialized successfully in AuthenticationController.');
        } catch (\Throwable $e) {
            Log::error('Failed to initialize Firebase: ' . $e->getMessage());
            throw new \Exception('Firebase initialization failed: ' . $e->getMessage());
        }
    }

    public function signup(Request $request)
    {
        Log::info('Signup method called.');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'required|string',
        ]);

        try {
            // Define user properties for Firebase Auth
            $userProperties = [
                'email' => $validatedData['email'],
                'password' => '000000', // Default password
                'emailVerified' => false,
                'displayName' => $validatedData['name'],
            ];

            // Create a Firebase user
            $createdUser = $this->auth->createUser($userProperties);
            Log::info('Firebase user created with UID: ' . $createdUser->uid);

            // Add user data to Firestore
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users');

            $usersRef->document($createdUser->uid)->set([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'department' => $validatedData['department'],
                'created_at' => new \DateTime(),
            ]);

            Log::info('User data added to Firestore.');
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully!',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error registering user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to register user. Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        \Log::info('Login method called.');

        // Validate the input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // Authenticate the user with Firebase
            $signInResult = $this->auth->signInWithEmailAndPassword($validatedData['email'], $validatedData['password']);
            \Log::info('User authenticated successfully.');

            // Fetch user data from Firestore
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users');
            $userDocs = $usersRef->where('email', '=', $validatedData['email'])->documents();

            $userData = null;
            foreach ($userDocs as $doc) {
                if ($doc->exists()) {
                    $userData = $doc->data();
                    break;
                }
            }

            // Check if user data exists
            if ($userData) {
                \Log::info('User data fetched from Firestore: ', $userData);

                // Save user data in session
                session([
                    'firebase_token' => $signInResult->idToken(),
                    'user_data' => $userData,
                    'user_email' => $validatedData['email'],
                    'department' => $userData['department'] ?? null, // Check if department exists
                ]);

                // Redirect based on department field
                if (!empty($userData['department'])) {
                    return redirect()->intended('/department/dashboard');
                }
            } else {
                \Log::warning('No user data found in Firestore. Redirecting to Dashboard.');
                // Save email in session and redirect to Dashboard
                session(['firebase_token' => $signInResult->idToken(), 'user_email' => $validatedData['email']]);
                return redirect()->intended('/Dashboard');
            }
        } catch (\Throwable $e) {
            \Log::error('Error during login: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Invalid credentials or user not found.'])->with('message', 'Error: ' . $e->getMessage());
        }
    }

    public function forgotPassword(Request $request)
    {
        \Log::info('Forgot Password method called.');

        // Validate the email input
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Verify if the email exists in Firebase
            $auth = $this->auth;
            $user = $auth->getUserByEmail($validatedData['email']);

            if (!$user) {
                throw new \Exception('Email not found in the system.');
            }

            // Send the password reset link
            $auth->sendPasswordResetLink($validatedData['email']);
            \Log::info('Password reset link sent successfully to: ' . $validatedData['email']);

            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent successfully.',
            ], 200);
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            \Log::error('Email not found: ' . $validatedData['email']);
            return response()->json([
                'success' => false,
                'message' => 'Email not found. Please check and try again.',
            ], 404);
        } catch (\Throwable $e) {
            \Log::error('Error sending password reset link: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send password reset link. Please try again.',
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        \Log::info('Logout method called.');

        // Clear the session data
        $request->session()->flush();

        \Log::info('User session cleared.');

        // Redirect to the login page
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }








    public function getUsers()
    {
        try {
            $users = [];
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users');
            $documents = $usersRef->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $userData = $document->data();
                    $userData['uid'] = $document->id(); // Add the UID from Firestore document ID
                    $users[] = $userData;
                }
            }

            Log::info('Fetched users successfully.');
            return response()->json($users, 200);
        } catch (\Throwable $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch users.'], 500);
        }
    }

    public function deleteUser($uid)
    {
        try {
            $auth = $this->auth;
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users');

            // Delete from Firebase Auth
            $auth->deleteUser($uid);
            Log::info('Firebase user deleted with UID: ' . $uid);

            // Delete from Firestore
            $usersRef->document($uid)->delete();
            Log::info('Firestore user deleted with UID: ' . $uid);

            return response()->json(['message' => 'User deleted successfully.'], 200);
        } catch (\Throwable $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }

    public function updateUser(Request $request, $uid)
    {
        Log::info('Update user method called for UID: ' . $uid);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|string',
        ]);

        try {
            // Update user data in Firestore
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users')->document($uid);

            $usersRef->set([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'department' => $validatedData['department'],
                'updated_at' => new \DateTime(),
            ], ['merge' => true]); // Merge option to update only the provided fields

            Log::info('User data updated successfully for UID: ' . $uid);
            return response()->json(['success' => true, 'message' => 'User updated successfully!'], 200);
        } catch (\Throwable $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update user.'], 500);
        }
    }

    public function editUser(Request $request, $uid)
    {
        Log::info("Edit user method called for UID: $uid");

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'department' => 'required|string',
        ]);

        try {
            // Update user in Firebase Auth
            Log::info('Updating Firebase user...');
            $this->auth->updateUser($uid, [
                'displayName' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);
            Log::info("Firebase user updated successfully for UID: $uid");

            // Update user in Firestore
            Log::info('Updating Firestore user document...');
            $database = $this->firestore->database();
            $usersRef = $database->collection('Users')->document($uid);

            $usersRef->update([
                ['path' => 'name', 'value' => $validatedData['name']],
                ['path' => 'email', 'value' => $validatedData['email']],
                ['path' => 'department', 'value' => $validatedData['department']],
            ]);
            Log::info("Firestore user document updated successfully for UID: $uid");

            return response()->json(['success' => true, 'message' => 'User updated successfully!']);
        } catch (\Throwable $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update user.'], 500);
        }
    }


}
