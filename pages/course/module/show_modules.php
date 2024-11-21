<?php
include '../../../vendor/autoload.php';

session_start();

use App\Helpers;
use App\Module;

$courseId = $_GET['id'];

$module = new Module();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $attachmentUrl = null;
    $teacherId = $_SESSION['userInfo']['id'] ?? '';

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {

        $attachmentUrl = Helpers::handleFileUpload($_FILES['attachment']);

    } else if ($_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        header("Location: show_modules.php?id=$courseId&error=".$_FILES['attachment']['error']);
    }

    $result = $module->createModuleTopic($title, $description, $courseId, $attachmentUrl);

    header("Location: show_modules.php?id=$courseId&message=Module added successfully");

    exit;
}

$topics = $module->getModuleTopics($courseId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - View Course</title>
    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Add Quill Theme CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
    <!-- Add Quill Core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.core.min.css" rel="stylesheet">
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
                <h2 class="text-2xl font-semibold text-gray-700">Topics</h2>
                <div class="flex items-center space-x-4">
                    <button
                    data-modal-target="default-modal"
                    data-modal-toggle="default-modal"
                    class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    style="margin-bottom: 20px">Add Module Topics</button>
                </div>
            </header>

            <div class="p-6 bg-white rounded-lg shadow-md mt-6">
                <!-- Your existing accordion content -->

                <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                    <?php foreach ($topics as $index => $topic): ?>
                        <h2 id="accordion-flush-heading-<?= $index ?>">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-<?= $index ?>" aria-expanded="false" aria-controls="accordion-flush-body-<?= $index ?>">
                                <span><?= htmlspecialchars($topic['title']) ?></span> <!-- Display topic title -->
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-<?= $index ?>" class="hidden" aria-labelledby="accordion-flush-heading-<?= $index ?>">
                            <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                <p class="mb-2 text-gray-500 dark:text-gray-400"><?= $topic['description'] ?></p> <!-- Display topic description -->
                                <?php if (!empty($topic['attachment'])): ?>
                                    <a href="<?= htmlspecialchars($topic['attachment']) ?>" class="text-blue-600 dark:text-blue-500 hover:underline">Download Attachment</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Topics
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form action="<?= $_SERVER['PHP_SELF']?>?id=<?= $courseId ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 w-full">
                        <!-- Module Title -->
                        <div class="mb-4">
                            <label for="module-title" class="block text-gray-700 font-medium">Title</label>
                            <input type="text" id="module-title" name="title"
                                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter module title" required>
                        </div>

                        <!-- Module Description -->
                        <div class="mb-4">
                            <label for="module-description" class="block text-gray-700 font-medium">Description</label>
                            <input type="hidden" id="description" name="description">
                            <div id="editor" class="mt-2" style="height: 300px;"></div>
                        </div>

                        <div class="mb-4">
                            <label for="attachment" class="block text-gray-700 font-medium">Upload Attachment (Optional)</label>
                            <input type="file" id="attachment" name="attachment"
                                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Add Module
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- Add Quill JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

    <script>
        // Initialize Quill
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Handle form submission
        document.querySelector('form').onsubmit = function() {
            // Get the HTML content from Quill
            const description = quill.root.innerHTML;
            // Set the value of the hidden input

            console.log('Quill Description:', description);

            document.querySelector('#description').value = description;
            return true;
        };

        // Focus Quill editor when modal opens
        document.querySelector('[data-modal-target="default-modal"]').addEventListener('click', function() {
            setTimeout(() => quill.focus(), 200);
        });

        const baseUrl = 'http://localhost/cloudease';

        // Handle link formatting
        quill.on('text-change', function(delta, oldDelta, source) {
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