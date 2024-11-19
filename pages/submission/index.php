<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Assignment Submissions</title>
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
            <?= $_SESSION['SidebarComponent'] ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Assignment Submissions</h2>

            <!-- Student List Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-left text-gray-600">
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Assignment Title</th>
                            <th class="px-4 py-2">Submission Date</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Student Row -->
                        <tr class="border-b">
                            <td class="px-4 py-2">1001</td>
                            <td class="px-4 py-2">Alice Johnson</td>
                            <td class="px-4 py-2">Introduction to Python</td>
                            <td class="px-4 py-2">2024-11-09</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-sm text-white bg-green-500 rounded">Submitted</span>
                            </td>
                            <td class="px-4 py-2">
                                <button class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">View</button>
                                <button class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">Mark</button>
                            </td>
                        </tr>

                        <!-- Another Student Row -->
                        <tr class="border-b">
                            <td class="px-4 py-2">1002</td>
                            <td class="px-4 py-2">Bob Smith</td>
                            <td class="px-4 py-2">Introduction to Python</td>
                            <td class="px-4 py-2">2024-11-08</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-sm text-white bg-red-500 rounded">Pending</span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="show.php" class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">View</a>
                                <button class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">Remind</button>
                            </td>
                        </tr>

                        <!-- Additional rows as needed -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
