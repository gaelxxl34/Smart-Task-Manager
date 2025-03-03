<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    protected $firestore;

    public function __construct()
    {
        if (env('FIREBASE_CREDENTIALS_BASE64')) {
            $firebaseCredentialsJson = base64_decode(env('FIREBASE_CREDENTIALS_BASE64'));
            if (!$firebaseCredentialsJson) {
                throw new \Exception('Failed to decode FIREBASE_CREDENTIALS_BASE64');
            }
            $serviceAccount = json_decode($firebaseCredentialsJson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to decode JSON: ' . json_last_error_msg());
            }
        } else {
            $firebaseCredentialsPath = env('FIREBASE_CREDENTIALS');
            if (!$firebaseCredentialsPath || !file_exists($firebaseCredentialsPath)) {
                throw new \Exception('Firebase credentials file path is not set or file does not exist');
            }
            $serviceAccount = $firebaseCredentialsPath;
        }

        $firebaseFactory = (new Factory)->withServiceAccount($serviceAccount);
        $this->firestore = $firebaseFactory->createFirestore()->database();
    }

    public function getCollection($collection)
    {
        return $this->firestore->collection($collection);
    }
}
