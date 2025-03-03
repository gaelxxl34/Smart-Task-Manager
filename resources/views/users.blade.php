<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

     <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
        }
        /* Loader Styles */
        .loader {
            border: 4px solid transparent;
            border-radius: 50%;
            border-top-color: #3498db;
            animation: spin 1s linear infinite;
            width: 3rem;
            height: 3rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

                /* Toast Notification Styles */
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background-color: #4caf50; /* Green for success */
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(-50px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .toast.error {
            background-color: #f44336; /* Red for error */
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    @include('partials.components.sidenavbar')

    <div class="p-4 sm:ml-64 mt-20">
        <!-- Add User Form -->
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-6">Manage Users</h1>
       
        <!-- Toast Notification -->
        <div id="toast" class="toast"></div>

        <!-- Loading Indicator -->
        <div id="loading-indicator" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="loader"></div>
        </div>
        
        <form id="add-user-form" action="/signup" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-8">
            @csrf
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Add New User</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm text-gray-600 dark:text-gray-300">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-300" 
                        required
                    >
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm text-gray-600 dark:text-gray-300">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-300" 
                        required
                    >
                </div>
                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm text-gray-600 dark:text-gray-300">Department</label>
                    <select 
                        id="department" 
                        name="department" 
                        class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-300" 
                        required
                    >
                        <option value="">Select Department</option>
                        <option value="HR">HR</option>
                        <option value="IT">IT</option>
                        <option value="Marketing">Marketing</option>
                    </select>
                </div>
            </div>
            <button 
                type="submit" 
                class="mt-4 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
                Add User
            </button>
        </form>
<div id="user-list" class="overflow-x-auto bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md mt-6">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Users</h2>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Department</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="users-tbody">
            <!-- Dynamic User Rows Will Be Injected Here -->
        </tbody>
    </table>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="modal flex">
    <div class="modal-content">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>
        <form id="edit-user-form">
            @csrf
            <!-- Hidden field to store the UID -->
            <input type="hidden" id="editUid" name="uid">
            
            <div class="mb-4">
                <label for="editName" class="block text-sm text-gray-600">Name</label>
                <input 
                    type="text" 
                    id="editName" 
                    name="name" 
                    class="w-full px-4 py-2 border rounded-md" 
                    required 
                    placeholder="Enter user's name"
                >
            </div>
            
            <div class="mb-4">
                <label for="editEmail" class="block text-sm text-gray-600">Email</label>
                <input 
                    type="email" 
                    id="editEmail" 
                    name="email" 
                    class="w-full px-4 py-2 border rounded-md" 
                    required 
                    placeholder="Enter user's email"
                >
            </div>
            
            <div class="mb-4">
                <label for="editDepartment" class="block text-sm text-gray-600">Department</label>
                <select 
                    id="editDepartment" 
                    name="department" 
                    class="w-full px-4 py-2 border rounded-md" 
                    required
                >
                    <option value="" disabled>Select Department</option>
                    <option value="HR">HR</option>
                    <option value="IT">IT</option>
                    <option value="Marketing">Marketing</option>
                </select>
            </div>
            
            <div class="flex justify-end">
                <button 
                    type="button" 
                    onclick="closeEditModal()" 
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="ml-2 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Save
                </button>
            </div>
        </form>
    </div>
</div>





    </div>

<script>
    const form = document.getElementById('add-user-form');
    const loadingIndicator = document.getElementById('loading-indicator');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Show loading indicator
        loadingIndicator.classList.remove('hidden');

        try {
            // Submit form via Fetch API
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: form.method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData,
            });

            const result = await response.json();

            // Check the `success` field in the JSON response
            if (result.success) {
                // Success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'User Created',
                    text: result.message,
                    timer: 3000,
                    showConfirmButton: false,
                });
                form.reset(); // Reset the form fields
            } else {
                // Error message with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: result.message || 'Failed to create user. Please try again.',
                });
            }
        } catch (error) {
            // General error message with SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred. Please try again later.',
            });
        } finally {
            // Hide loading indicator
            loadingIndicator.classList.add('hidden');
        }
    });


</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const usersTbody = document.getElementById('users-tbody');
        const editModal = document.getElementById('editModal');
        const editForm = document.getElementById('edit-user-form');
        const editName = document.getElementById('editName');
        const editEmail = document.getElementById('editEmail');
        const editDepartment = document.getElementById('editDepartment');
        const editUid = document.getElementById('editUid');

        const fetchUsers = async () => {
            try {
                const response = await fetch('/get-users');
                if (!response.ok) {
                    throw new Error('Failed to fetch users.');
                }
                const users = await response.json();

                usersTbody.innerHTML = ''; // Clear existing rows
                users.forEach(user => {
                    const tr = document.createElement('tr');
                    tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700';

                    tr.innerHTML = `
                        <td class="px-4 py-2">${user.name}</td>
                        <td class="px-4 py-2">${user.email}</td>
                        <td class="px-4 py-2">${user.department}</td>
                        <td class="px-4 py-2">
                            <button onclick="openEditModal('${user.uid}', '${user.name}', '${user.email}', '${user.department}')" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Edit</button>
                            <button onclick="confirmDelete('${user.uid}')" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                        </td>
                    `;
                    usersTbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error fetching users:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch users. Please try again later.',
                });
            }
        };

        // Open Edit Modal
        window.openEditModal = (uid, name, email, department) => {
            editName.value = name;
            editEmail.value = email;
            editDepartment.value = department;
            editUid.value = uid;
            editModal.style.display = 'flex';
        };

        // Close Edit Modal
        window.closeEditModal = () => {
            editModal.style.display = 'none';
        };

        // Edit User Form Submission
        editForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const uid = editUid.value;

            try {
                const formData = new FormData(editForm);
                const response = await fetch(`/edit-user/${uid}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                });

                if (response.ok) {
                    const result = await response.json();
                    Swal.fire({
                        icon: 'success',
                        title: 'User Updated',
                        text: result.message || 'User updated successfully!',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    closeEditModal();
                    fetchUsers();
                } else {
                    const result = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Failed to update user. Please try again.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again later.',
                });
                console.error('Error editing user:', error);
            }
        });

        // Confirm Delete
        window.confirmDelete = async (uid) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/delete-user/${uid}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            },
                        });

                        if (response.ok) {
                            const result = await response.json();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: result.message || 'User deleted successfully!',
                                timer: 3000,
                                showConfirmButton: false,
                            });
                            fetchUsers();
                        } else {
                            const result = await response.json();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.message || 'Failed to delete user. Please try again.',
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again later.',
                        });
                        console.error('Error deleting user:', error);
                    }
                }
            });
        };

        // Fetch users on page load
        fetchUsers();
    });
</script>


</body>
</html>
