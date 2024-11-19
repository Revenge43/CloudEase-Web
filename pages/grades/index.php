<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="h-screen w-screen bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col h-full">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Cloudease LMS</h1>
            </div>
            <nav class="flex-1 px-4 py-2">
                <a href="index.html" class="block py-2 px-4 mb-2 text-blue-100 rounded hover:bg-blue-700">Dashboard</a>
                <a href="index.html" class="block py-2 px-4 mb-2 text-blue-100 rounded hover:bg-blue-700">Courses</a>
                <a href="assignments.html" class="block py-2 px-4 mb-2 text-blue-100 rounded hover:bg-blue-700">Assignments</a>
                <a href="grades.html" class="block py-2 px-4 mb-2 text-blue-100 rounded hover:bg-blue-700">Grades</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Grades</h2>

            <!-- Grades Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-left text-gray-600">
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Course</th>
                            <th class="px-4 py-2">Assignment</th>
                            <th class="px-4 py-2">Grade</th>
                            <th class="px-4 py-2">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr class="border-b">
                            <td class="px-4 py-2">1001</td>
                            <td class="px-4 py-2">Alice Johnson</td>
                            <td class="px-4 py-2">Introduction to Python</td>
                            <td class="px-4 py-2">Assignment 1</td>
                            <td class="px-4 py-2 text-green-500 font-bold">95</td>
                            <td class="px-4 py-2">
                                <button onclick="location.href='view-assignment.html'" class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">View Feedback</button>
                            </td>
                        </tr>

                        <!-- Another Example Row -->
                        <tr class="border-b">
                            <td class="px-4 py-2">1002</td>
                            <td class="px-4 py-2">Bob Smith</td>
                            <td class="px-4 py-2">Introduction to Python</td>
                            <td class="px-4 py-2">Assignment 1</td>
                            <td class="px-4 py-2 text-yellow-500 font-bold">80</td>
                            <td class="px-4 py-2">
                                <button onclick="location.href='view-assignment.html'" class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">View Feedback</button>
                            </td>
                        </tr>

                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
