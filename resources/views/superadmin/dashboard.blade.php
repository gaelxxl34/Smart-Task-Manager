<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src='https://cdn.plot.ly/plotly-2.35.2.min.js'></script>

    <style>
        .icon-size {
            font-size: 2rem; /* Adjust this size as needed */
            /* color: #9b9a9a */
        }
    </style>
</head>
<body>

    @include('partials.components.sidenavbar')
    <div class="p-4 sm:ml-64 mt-20">
        <div class="grid grid-cols-1 gap-4 px-2 sm:grid-cols-4 sm:px-8">
            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <div class="p-4 bg-green-400">
                    <i class="fas fa-tasks icon-size text-white"></i>
                </div>
                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Total Tasks</h3>
                    <p class="text-3xl">2</p>
                </div>
            </div>
            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <div class="p-4 bg-blue-400">
                    <i class="fas fa-check-circle icon-size text-white"></i>
                </div>
                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Completed Tasks</h3>
                    <p class="text-3xl">1</p>
                </div>
            </div>
            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <div class="p-4 bg-indigo-400">
                    <i class="fas fa-clock icon-size text-white"></i>
                </div>
                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Pending Tasks</h3>
                    <p class="text-3xl">5</p>
                </div>
            </div>
            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <div class="p-4 bg-red-400">
                    <i class="fas fa-exclamation-triangle icon-size text-white"></i>
                </div>
                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Overdue Tasks</h3>
                    <p class="text-3xl">3%</p>
                </div>
            </div>
            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <div class="p-4 bg-gradient-to-r from-purple-400 to-purple-600 ">
                    <i class="fas fa-user icon-size text-white"></i>
                </div>

                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Active Users</h3>
                    <p class="text-3xl">1</p>
                </div>
            </div>

            <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                <!-- Icon Section -->
                <div class="p-4 bg-gradient-to-r from-green-400 to-green-600">
                    <i class="fas fa-building icon-size text-white"></i>
                </div>

                <!-- Text Section -->
                <div class="px-4 text-gray-700">
                    <h3 class="text-sm tracking-wider">Departments</h3>
                    <p class="text-3xl">5</p>
                </div>
            </div>

        </div>
        <!-- Container for the chart -->
	    <div id='myDiv' style="width: 100%; height: 500px;"><!-- Plotly chart will be drawn inside this DIV --></div>

        <div class="mt-8 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Activity</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Activity</th>
                            <th scope="col" class="px-4 py-3">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-4 py-3">John Doe completed Task #34</td>
                            <td class="px-4 py-3">10 mins ago</td>
                        </tr>
                        <tr class="bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
                            <td class="px-4 py-3">Jane Smith added a new task</td>
                            <td class="px-4 py-3">1 hour ago</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-4 py-3">Task #42 marked as overdue</td>
                            <td class="px-4 py-3">3 hours ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


	<script>
		// Data for Tasks by Department
		var trace1 = {
			x: ['Marketing', 'IT', 'HR', 'Finance', 'Sales', 'AR'], // Departments
			y: [50, 70, 40, 90, 60, 40], // Completed Tasks
			name: 'Completed Tasks',
			type: 'bar',
			marker: {
				color: '#7A1414' // Custom color for Completed Tasks
			}
		};

		var trace2 = {
			x: ['Marketing', 'IT', 'HR', 'Finance', 'Sales', 'AR'], // Departments
			y: [30, 20, 35, 10, 15, 20], // Pending Tasks
			name: 'Pending Tasks',
			type: 'bar',
			marker: {
				color: '#9b9a9a' // Custom color for Pending Tasks
			}
		};

		// Combine both traces
		var data = [trace1, trace2];

		// Layout configuration
		var layout = {
			barmode: 'group', // Grouped bar chart
			title: {
				text: 'Tasks Completed vs Pending by Department',
				font: {
					size: 16 // Reduce title font size
				}
			},
			xaxis: {
				title: {
					text: 'Departments',
					font: {
						size: 12 // Reduce x-axis title font size
					}
				},
				tickangle: -45 // Rotate x-axis labels if needed
			},
			yaxis: {
				title: {
					text: 'Number of Tasks',
					font: {
						size: 12 // Reduce y-axis title font size
					}
				}
			},
			legend: {
				orientation: 'h', // Horizontal legend at the bottom
				x: 0.5,
				y: -0.2,
				xanchor: 'center',
				font: {
					size: 10 // Reduce legend font size
				}
			}
		};

		// Render the chart in the div with ID 'myDiv'
		Plotly.newPlot('myDiv', data, layout);
	</script>

</body>
</html>
