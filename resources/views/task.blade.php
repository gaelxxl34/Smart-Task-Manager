<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Semester Calendar</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
        }

        .close-modal {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>
    @include('partials.components.sidenavbar')

    <!-- Main Content -->
    <div class="p-4 sm:ml-64 mt-20 flex flex-col">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Semester Calendar</h2>

        <!-- Semester List -->
        @if(count($semesters) > 0)
            <ul class="list-none space-y-3">
                @foreach ($semesters as $semester)
                    <li class="p-4 bg-white shadow rounded-lg flex justify-between items-center cursor-pointer hover:bg-gray-100"
                        onclick="redirectToSemester('{{ $semester['start_date'] }}', '{{ $semester['end_date'] }}')">
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-200">
                                {{ $semester['name'] }}
                            </span>
                            <span class="text-gray-500 text-sm"> ({{ \Carbon\Carbon::parse($semester['start_date'])->format('M d, Y') }}
                                -
                                {{ \Carbon\Carbon::parse($semester['end_date'])->format('M d, Y') }})</span>
                        </div>
                        <div>
                            @if ($semester['status'] === 'current')
                                <span class="px-3 py-1 text-white bg-green-500 rounded-full text-sm">Current</span>
                            @else
                                <span class="px-3 py-1 text-white bg-gray-500 rounded-full text-sm">Past</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

        @else
            <p class="text-gray-500 text-center">No semesters available. Create one below.</p>
        @endif

        <!-- Create Semester Button -->
        <div class="flex justify-end mt-6">
            <button id="openModal"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-all duration-300">
                Create Semester
            </button>
        </div>

        <!-- Modal for Creating a Semester -->
        <div id="semesterModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" id="closeModal">&times;</span>
                <h3 class="text-lg font-semibold">Create Semester</h3>
                <form action="{{ route('semester.store') }}" method="POST">
                    @csrf
                    <div class="mt-2">
                        <label for="name" class="block text-gray-600">Semester Name</label>
                        <input type="text" name="name" required class="w-full border p-2 rounded">
                    </div>

                    <div class="mt-2">
                        <label for="start_date" class="block text-gray-600">Start Date</label>
                        <input type="date" name="start_date" required class="w-full border p-2 rounded">
                    </div>

                    <div class="mt-2">
                        <label for="end_date" class="block text-gray-600">End Date</label>
                        <input type="date" name="end_date" required class="w-full border p-2 rounded">
                    </div>

                    <button type="submit"
                        class="mt-4 w-full px-6 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
                        Save Semester
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("openModal").onclick = function () {
            document.getElementById("semesterModal").style.display = "block";
        };

        document.getElementById("closeModal").onclick = function () {
            document.getElementById("semesterModal").style.display = "none";
        };
    </script>

<script>
    function redirectToSemester(startDate, endDate) {
        let formattedStart = new Date(startDate).toISOString().split('T')[0]; // Format as YYYY-MM-DD
        let formattedEnd = new Date(endDate).toISOString().split('T')[0]; // Format as YYYY-MM-DD

        let formattedUrl = formattedStart + "_" + formattedEnd; // Join using underscore
        window.location.href = `/task/semester/details/${formattedUrl}`;
    }
</script>


</body>

</html>