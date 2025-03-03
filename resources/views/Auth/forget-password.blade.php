<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>Forget Password</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <p class="mt-2">Reset your password</p>
            </div>

            <!-- Form -->
            <form id="forgot-password-form" action="/forgot-password" method="POST" class="space-y-6">
                @csrf
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        class="input-field w-full rounded-lg px-4 py-2"
                        placeholder="your@email.com" 
                        required>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-primary w-full rounded-lg py-2">Send Reset Link</button>
                </div>
            </form>

            <!-- Footer -->
            <p class="mt-6 text-center text-sm">
                <a href="/login" class="underline">Go back to login page</a>
            </p>
        </div>
    </div>

    <script>
        const form = document.getElementById('forgot-password-form');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            const email = formData.get('email');

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email }),
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password reset link sent successfully!',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                } else {
                    const result = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Failed to send password reset link. Please try again.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again later.',
                });
            }
        });
    </script>
</body>
</html>
