<?php
include '../../vendor/autoload.php';

use App\Assignment;

session_start();

$assignments = new Assignment();
$assignments = $assignments->getAssignments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Assignments</title>
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
           <?= $_SESSION['SidebarComponent'] ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <!-- Header -->
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Assignments</h2>
                <button onclick="location.href='create.php'"
                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add Assignment
                </button>
            </header>

            <!-- Assignment Cards -->
            <div class="p-6 grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                <!-- Assignment Card 1 -->
                 <?php foreach ($assignments as $index => $assignment) : ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-800">Assignment <?= $index + 1?>: <?= $assignment['assignment_title'] ?></h3>
                    <p class="mt-2 text-gray-600"><?= $assignment['assignment_description'] ?></p>
                    <p class="mt-2 text-sm text-gray-500">Score: <?= $assignment['assignment_score'] ?></p>
                    <a href="show.php?id=<?= $assignment['id'] ?>&courseId=<?= $assignment['course_id'] ?>" class="mt-4 inline-block text-blue-600 hover:underline">View Assignment</a>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
