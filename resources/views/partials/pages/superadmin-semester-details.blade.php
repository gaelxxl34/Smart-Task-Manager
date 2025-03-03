<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jan to April 2025</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        /* Excel-like styling for textareas */
        .excel-table textarea {
            display: block;
            width: 100%;
            border: none;
            outline: none;
            padding: 0.5rem;
            background-color: transparent;
            resize: none; /* Disable manual resizing */
            text-align: left;
            font-size: 0.9rem;
            overflow: hidden; /* Hide default scrollbar */
        }

        .excel-table textarea:focus {
            border: 1px solid #7A1414;
            background-color: #f9f9f9;
        }

        /* Grid-like table */
        .excel-table td {
            border: 1px solid #ddd;
            padding: 0;
        }

        .excel-table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
        }

        .excel-table th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: left;
            border: 1px solid #ddd;
            padding: 0.5rem;
        }

        .dark-mode .excel-table th {
            background-color: #333;
            color: #fff;
        }
    </style>
    
</head>

    <body class="bg-gray-100 dark:bg-gray-900">
        @include('partials.components.sidenavbar')

        <div class="p-4 sm:ml-64 mt-20">
        <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">
            Semester: {{ $formattedSemester }}
        </h1>




            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded">{{ session('success') }}</div>
            @endif

            <!-- Task Table -->
            <div class="overflow-x-auto">
                <table class="excel-table text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead>
                        <tr>
                            <th>Deadline</th>
                            <th>Task Name</th>
                            <th>Activities Involved</th>
                            <th>People Responsible</th>
                            <th>Supervisor</th>
                            <th>Supervisor Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task['deadline'] }}</td>
                                <td>{{ $task['task_name'] }}</td>
                                <td>{{ $task['activities'] }}</td>
                                <td>{{ implode(', ', $task['responsible']) }}</td>
                                <td>{{ $task['supervisor'] }}</td>
                                <td>{{ $task['supervisor_email'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Add Task Form -->
            <form action="{{ route('task.store', ['semester' => str_replace(' ', '_', $formattedSemester)]) }}" method="POST">

                @csrf
                <div class="grid grid-cols-6 gap-2 mt-4">
                    <input type="date" name="deadline" required class="border p-2 rounded">
                    <input type="text" name="task_name" placeholder="Task Name" required class="border p-2 rounded">
                    <input type="text" name="activities" placeholder="Activities Involved" required
                        class="border p-2 rounded">
                    <input type="text" name="responsible" placeholder="People Responsible" required
                        class="border p-2 rounded">
                    <input type="text" name="supervisor" placeholder="Supervisor" required class="border p-2 rounded">
                    <input type="email" name="supervisor_email" placeholder="Supervisor Email" required
                        class="border p-2 rounded">
                </div>
                <button type="submit" class="mt-4 px-6 py-2 bg-green-600 text-white rounded">Save Task</button>
            </form>
        </div>
    </body>


</html>
