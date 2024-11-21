<?php

include '../../vendor/autoload.php';

session_start();

use App\Course;

$course = new Course();

$courses = $course->getCourses();

if (isset($_GET['id'])) {
    $courseId = $_GET['id'];
    $courseApi = new Course();
    $deleted = $courseApi->deleteCourse($courseId);

    if ($deleted) {
        header('Location: index.php?status=success');
    } else {
        header('Location: index.php?status=error');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>

    </style>
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
        <main class="flex-1">
            <!-- Top Navbar -->
            <?= $_SESSION['HeaderComponent'] ?>

            <!-- Courses Content -->
            <div class="p-6 bg-gray-100">
              
            </div>

        </main>
    </div>
</body>
</html>
