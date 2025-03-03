<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department Dashboard</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    
    @include('partials.components.sidenavbar')

<div class="p-4 sm:ml-64 mt-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-lg shadow-md mb-6">
        <div>
            <h1 class="text-3xl font-bold">Welcome to Your Dashboard</h1>
            <p class="mt-1 text-sm">Here's a summary of your department's activities and updates.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <div class="flex items-center bg-white text-gray-700 rounded-lg shadow-md p-4">
                <div class="flex-shrink-0 bg-blue-100 text-blue-500 rounded-full p-3">
                    <i class="fas fa-tasks text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium">Total Tasks</p>
                    <h2 class="text-2xl font-bold">12</h2> <!-- Replace dynamically -->
                </div>
            </div>
            <div class="flex items-center bg-white text-gray-700 rounded-lg shadow-md p-4">
                <div class="flex-shrink-0 bg-yellow-100 text-yellow-500 rounded-full p-3">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium">Pending Tasks</p>
                    <h2 class="text-2xl font-bold">5</h2> <!-- Replace dynamically -->
                </div>
            </div>
            <div class="flex items-center bg-white text-gray-700 rounded-lg shadow-md p-4">
                <div class="flex-shrink-0 bg-green-100 text-green-500 rounded-full p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium">Completed Tasks</p>
                    <h2 class="text-2xl font-bold">7</h2> <!-- Replace dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="space-y-8">
        <!-- Tasks Section -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Assigned Tasks</h2>

            <!-- Placeholder for tasks -->
            <div id="tasks-container" class="space-y-4">
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">Task Title</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        This is a placeholder description for a task assigned to the department.
                    </p>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Due Date: January 20, 2025</span>
                        <button class="px-4 py-2 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            View Details
                        </button>
                    </div>
                </div>

                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">Another Task Title</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        This is another placeholder description for a task assigned to the department.
                    </p>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Due Date: February 10, 2025</span>
                        <button class="px-4 py-2 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- No tasks placeholder -->
            <div id="no-tasks-placeholder" class="hidden text-center py-6">
                <p class="text-gray-600 dark:text-gray-400">
                    No tasks have been assigned to your department yet.
                </p>
            </div>
        </div>


        <!-- Overdue Tasks Section -->
        <div class="bg-red-100 dark:bg-red-800 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-red-700 dark:text-red-200 mb-4">Overdue Tasks</h2>
            <div id="overdue-tasks-container" class="space-y-4">
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">Task Title</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        This is a placeholder description for an overdue task.
                    </p>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Due Date: January 10, 2025</span>
                        <button class="px-4 py-2 text-sm bg-red-500 text-white rounded-md hover:bg-red-600">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- No overdue tasks placeholder -->
            <div id="no-overdue-tasks-placeholder" class="hidden text-center py-6">
                <p class="text-gray-600 dark:text-gray-400">
                    No overdue tasks at the moment.
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Recent Activity</h2>
    <ul class="space-y-4">
        <li class="text-sm text-gray-600 dark:text-gray-400">
            Task "<span class="font-semibold text-gray-700 dark:text-gray-200">Prepare Presentation</span>" was completed by John Doe.
        </li>
        <li class="text-sm text-gray-600 dark:text-gray-400">
            New task "<span class="font-semibold text-gray-700 dark:text-gray-200">Review Budget</span>" assigned to your department.
        </li>
    </ul>
</div>

    </div>
</div>



</body>
</html>
