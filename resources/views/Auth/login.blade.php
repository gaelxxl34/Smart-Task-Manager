<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Smart Task Manager</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>
<body class="light-mode">
    <!-- Container -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="card max-w-md w-full rounded-lg shadow-lg p-8">
            <!-- Logo Section -->
            <div class="flex justify-center mb-6">
                <img src="https://iuea.ac.ug/Blog/wp-content/uploads/2020/11/Website-Logo.png" alt="IUEA Logo" class="h-16 w-auto">
            </div>

            <!-- Logo Text -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold">Smart Task Manager</h1>
                <p class="mt-2">Organize tasks smarter and faster</p>
            </div>

            <!-- Error Message Section -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        class="input-field w-full rounded-lg px-4 py-2 border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Email Address" 
                        required>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="input-field w-full rounded-lg px-4 py-2 border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="Password" 
                        required>
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" class="btn-primary w-full rounded-lg py-2 bg-blue-500 text-white hover:bg-blue-600">
                        Log in
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <p class="mt-6 text-center text-sm">
                <a href="{{ route('forget-password') }}" class="underline text-blue-500 hover:text-blue-600">Forgot Password?</a>
            </p>
        </div>
    </div>
</body>

</html>

