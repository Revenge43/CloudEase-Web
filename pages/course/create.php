<?php

include '../../vendor/autoload.php';

session_start();

use App\Course;
use App\Helpers;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $attachmentUrl = null;
    $teacherId = $_SESSION['userInfo']['id'] ?? '';

    $course = new Course();

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {

        $attachmentUrl = Helpers::handleFileUpload($_FILES['attachment']);

    } else if ($_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {

        header("Location: create.php?error=".$_FILES['attachment']['error']);
    }

    if ($title && $description) {

        $result = $course->createCourse($title, $description, $attachmentUrl, $teacherId);

    } else {

        header("Location: create.php?error=Please fill in all required fields");

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Create New Course</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
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
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Create New Course</h2>
            <?php if (isset($_GET['error'])): ?>
                <div class="flex items-center mt-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Error</span>
                    <div>
                        <?= htmlspecialchars($_GET['error']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Course Creation Form -->
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md w-full">

                <div class="mb-4">
                    <label for="course-title" class="block text-gray-700 font-medium">Course Title</label>
                    <input type="text" id="course-title" name="title"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label for="course-description" class="block text-gray-700 font-medium">Description</label>
                    <input type="hidden" id="course-description" name="description">
                    <div id="editor" style="height: 300px;"></div>
                </div>

                <div class="mb-4">
                    <label for="course-image" class="block text-gray-700 font-medium">Image</label>
                    <input type="file" id="course-image" name="attachment"
                           class="">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create
                        Course</button>
                </div>
            </form>

        </main>
    </div>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Handle form submission to populate the hidden input with Quill content
        document.querySelector('form').onsubmit = function () {
            document.querySelector('input[name=description]').value = quill.root.innerHTML;
        };

        const baseUrl = 'http://localhost/cloudease';

        quill.on('text-change', function (delta, oldDelta, source) {
            if (source === 'user') {
                delta.ops.forEach(op => {
                    if (op.insert && typeof op.insert === 'object' && op.insert.link) {
                        // Check if the link lacks a protocol
                        if (!/^https?:\/\//i.test(op.insert.link)) {
                            const fullLink = `${baseUrl}/${op.insert.link.replace(/^\/+/, '')}`;
                            // Apply the full URL
                            quill.format('link', fullLink);
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>
