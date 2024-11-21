<?php
include '../../../vendor/autoload.php';

session_start();

use App\Course;
use App\Module;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['module_title'] ?? null;
    $description = $_POST['module_description'] ?? null;
    $courseId = $_GET['id'] ?? '';
    // $attachmentUrl = null;

    if (!$title || !$description) {

        header("Location: create.php?error=Please fill in all required fields");

        exit;
    }

    $courseModule = new Course();

    // if (isset($_FILES['module_file']) && $_FILES['module_file']['error'] === UPLOAD_ERR_OK) {
    //     $attachmentUrl = Helpers::handleFileUpload($_FILES['module_file']);

    //     if (!$attachmentUrl) {

    //         header("Location: create.php?error=File upload failed");

    //         exit;
    //     }
    // }

    $module = new Module();

    $module->createModule($title, $description, $courseId);

    header("Location: ../show.php?id=$courseId&message=Module added successfully");

    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Add Module</title>
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
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Add Module</h2>
                <a href="../show.php?id=<?= $_GET['id']?>" class="text-blue-600 hover:underline">Back to Course</a>
            </header>

            <!-- Add Module Form -->
            <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                <form action="<?= $_SERVER['PHP_SELF']?>?id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md w-full">
                    <!-- Module Title -->
                    <div class="mb-4">
                        <label for="module-title" class="block text-gray-700 font-medium">Module Title</label>
                        <input type="text" id="module-title" name="module_title"
                               class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter module title" required>
                    </div>

                    <!-- Module Description -->
                    <div class="mb-4">
                        <label for="module-description" class="block text-gray-700 font-medium">Description</label>
                        <textarea id="module-description" name="module_description" rows="4"
                                  class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Enter a brief description of the module"></textarea>
                    </div>

                    <!-- File Upload (Optional) -->
                        <!-- <div class="mb-4">
                            <label for="module-file" class="block text-gray-700 font-medium">Upload Attachment (Optional)</label>
                            <input type="file" id="module-file" name="module_file"
                                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div> -->

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Module
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
