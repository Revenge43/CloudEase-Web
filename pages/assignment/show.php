<?php
include '../../vendor/autoload.php';
use App\Assignment;
use App\Comments;

session_start();
$id = $_GET['id'];
$assignment = new Assignment();
$assignmentData = $assignment->getAssignments();
$assignmentData = array_filter($assignmentData, function($assignment) use ($id) {

    return $assignment['course_id'] === $id;
});

$assignmentDataByCourseId = $assignment->getAssignment($id);

$filePath = $assignmentDataByCourseId[0]['assignment_file'] ?? '';

$comments = new Comments();

$commentsData = $comments->getComments();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Assignments</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>

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
            </header>

            <!-- Video Embed Section -->
            <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800">Assignment Video Overview</h3>
                    <?= $assignment->renderAttachment($filePath); ?>
            </div>

            <!-- Comments Section -->
            <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                <h4 class="text-xl font-semibold text-gray-800">Comments</h4>
                <form action="submit_comment.php" method="POST" class="mt-4">
                    <label for="comment" class="block text-gray-700 font-medium">Add a Comment</label>
                    <textarea id="comment" name="comment" rows="3"
                              class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write your comment here..." required></textarea>
                    <button type="submit"
                            class="mt-3 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>
                </form>

                <!-- Display Comments -->
                <div class="mt-6">
                    <?php foreach ($commentsData as $index => $comment) : ?>
                    <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4">
                        <p class="text-gray-700"><span class="font-semibold"><?= ucwords($comments->getUserName($comment['user_id'])[0]['name']) ?>:</span> <?= $comment['text'] ?></p>
                        <p class="text-sm text-gray-500">Posted on: <?= date('M d, Y', strtotime($comment['created_at'])); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                <h4 class="text-xl font-semibold text-gray-800">Available Assignments</h4>
                <div id="assignments-list" class="mt-4">
                    <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4">
                        <h5 class="text-lg font-semibold text-gray-800">Assignment 1: Introduction to Python</h5>
                        <p class="mt-2 text-gray-600">Learn the basics of Python programming and complete the exercises provided.</p>
                        <p class="text-sm text-gray-500">Due Date: 2024-11-15</p>
                        <a href="view-assignment.html"
                           class="mt-2 inline-block text-blue-600 hover:underline">View Assignment</a>
                    </div>
                </div>
            </div> -->
        </main>
    </div>
</body>
</html>
