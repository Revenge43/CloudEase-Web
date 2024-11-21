<?php
session_start();

if (!isset($_SESSION['access_token'])) {

    header("Location: forbidden.php");

    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - View Assignment</title>
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
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">View Assignment</h2>

            <!-- Assignment Details Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Assignment Details</h3>
                <p><strong>Title:</strong> Introduction to Python</p>
                <p><strong>Student:</strong> Alice Johnson</p>
                <p><strong>Submission Date:</strong> 2024-11-09</p>
                <p><strong>Status:</strong>
                    <span class="px-2 py-1 text-sm text-white bg-green-500 rounded">Submitted</span>
                </p>
            </div>

            <!-- Submitted File Section -->
            <div class="bg-white p-6 mt-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Submitted Work</h3>
                <p><strong>File:</strong> <a href="#" class="text-blue-600 hover:underline">python_basics_assignment.pdf</a></p>
                <p><strong>Comments:</strong> Here's my assignment submission. Let me know if you have any questions!</p>
            </div>

            <!-- Grading Section -->
            <div class="bg-white p-6 mt-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Grade Assignment</h3>
                <form>
                    <div class="mb-4">
                        <label for="grade" class="block text-gray-700 font-medium">Grade (out of 100)</label>
                        <input type="number" id="grade" name="grade" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="feedback" class="block text-gray-700 font-medium">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit Grade</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
