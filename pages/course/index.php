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
                <!-- New Button for Creating Course -->
                <a  href="create.php" class="px-4 py-2 mb-6 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create New Course
                </a>
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 mt-5">Available Courses</h2>

                <!-- Course Cards Grid -->
                    <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                        <!-- Loop through each course -->
                        <?php foreach ($courses as $course) : ?>
                            <div class="bg-white rounded-lg shadow-md p-4">
                                <img src="<?= '../../uploads/' . $course['image'] ?? 'https://placehold.co/600x400?text=' . ucwords(substr($course['title'], 0, 1)) ?>" alt="Course Image" class="w-full h-64 object-cover">
                                <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($course['title']); ?></h3>
                                <p class="mt-2 text-gray-600"><?= $course['description']; ?></p>
                                <!-- Link to view the course -->
                                <a href="show.php?id=<?= urlencode($course['course_id']); ?>" class="mt-4 inline-block text-blue-600 hover:underline">View Course</a>
                                <!-- Link to remove the course (points to a delete handler) -->
                                <a href="index.php?id=<?= urlencode($course['course_id']); ?>" class="mt-4 inline-block text-red-600 hover:underline">Remove</a>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
