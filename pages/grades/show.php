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
                <h1 class="text-2xl font-bold">Cloudease</h1>
            </div>
            <?= $_SESSION['sidebar'] ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Grades</h2>
                <a href="courses.php" class="text-blue-600 hover:underline">Back to Courses</a>
            </header>

            <div class="p-6 bg-white rounded-lg shadow-md mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Your Grades</h3>

                <!-- Grades Table -->
                <table class="w-full bg-gray-100 rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Instructor</th>
                            <th class="px-4 py-2 text-center">Grade</th>
                            <th class="px-4 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row 1 -->
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-4 py-4 text-gray-800">Introduction to Python</td>
                            <td class="px-4 py-4 text-gray-600">Jane Smith</td>
                            <td class="px-4 py-4 text-center text-gray-700 font-semibold">85%</td>
                            <td class="px-4 py-4 text-center text-green-600 font-semibold">Passed</td>
                        </tr>

                        <!-- Example Row 2 -->
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-4 py-4 text-gray-800">Web Development with HTML & CSS</td>
                            <td class="px-4 py-4 text-gray-600">Mark Lee</td>
                            <td class="px-4 py-4 text-center text-gray-700 font-semibold">90%</td>
                            <td class="px-4 py-4 text-center text-green-600 font-semibold">Passed</td>
                        </tr>

                        <!-- Example Row 3 -->
                        <tr class="bg-white border-b border-gray-200">
                            <td class="px-4 py-4 text-gray-800">Data Science Essentials</td>
                            <td class="px-4 py-4 text-gray-600">Sarah Johnson</td>
                            <td class="px-4 py-4 text-center text-gray-700 font-semibold">70%</td>
                            <td class="px-4 py-4 text-center text-yellow-600 font-semibold">On Probation</td>
                        </tr>

                        <!-- Additional Grade Rows -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
