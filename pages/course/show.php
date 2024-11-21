<?php

include '../../vendor/autoload.php';

session_start();

use App\Course;
use App\Assignment;

if (!isset($_SESSION['access_token'])) {

    header("Location: ../../forbidden.php");

    exit;
}

$courseId = $_GET['id'];

$course = new Course();

$courseDetails = $course->getCourse($courseId);

$modules = $course->getModuleById($courseId);

$assignments = new Assignment();

$assignmentsData = $assignments->getAssignments();

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - View Course</title>
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
            <!-- Header Section -->
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Course Details</h2>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="text-blue-600 hover:underline">Back to Courses</a>
                    <!-- Dropdown Add Button -->
                    <div class="relative">
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                class="flex items-center px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Add
                            <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdown" class="hidden absolute right-0 z-10 mt-2 w-44 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="assignment/create.php?id=<?= $_GET['id'] ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Assignment</a>
                                </li>
                                <li>
                                    <a href="module/create.php?id=<?= $_GET['id'] ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Module</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Section -->
            <div class="p-6 bg-white rounded-lg shadow-md mt-6">
                <!-- Course Information -->
                <h3 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($courseDetails['title']); ?></h3>
                <p class="mt-4 text-gray-700"><?= $courseDetails['description']  ; ?></p>

                <!-- Downloadable Attachments -->
                <div class="mt-6">
                    <h4 class="text-xl font-semibold text-gray-700">Assignments</h4>
                    <ul class="mt-2">
                        <?php foreach($assignmentsData as $index => $assignment): ?>
                            <li>
                                <a href="../assignment/show.php?id=<?= $assignment['course_id'] ?>" class="text-blue-600 hover:underline">Assignment #<?= $index + 1 ?> &nbsp; <?= ucwords($assignment['assignment_title']) ; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

               <?php if (count($modules) > 0) : ?>
                <div class="mt-8">
                    <h4 class="text-xl font-semibold text-gray-700">Course Modules</h4>
                    <div class="grid gap-4 lg:grid-cols-2 sm:grid-cols-1 mt-4">
                        <!-- Module Card 1 -->

                        <?php foreach ($modules as $module) : ?>
                            <div class="bg-white shadow-lg rounded-lg p-4 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                                <h5 class="text-lg font-semibold text-gray-800 mb-2"><?= htmlspecialchars($module['module_title']); ?></h5>
                                <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($module['module_description']); ?></p>
                                <div class="flex justify-end items-center">
                                    <a href="module/show_modules.php?id=<?= urlencode($module['id']); ?>" class="">Open Module</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
