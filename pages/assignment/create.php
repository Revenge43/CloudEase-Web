    <?php
    include '../../vendor/autoload.php';

    session_start();

    use App\Course;
    use App\Assignment;
    use App\Helpers;

    $courses = new Course();
    $coursesData = $courses->getCourses();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $title = $_POST['assignment_title'] ?? null;
        $description = $_POST['description'] ?? null;
        $score = $_POST['assignment_score'];
        $courseId = $_POST['course_id'] ?? null;
        $attachmentUrl = null;

        $courseModule = new Course();

        if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] === UPLOAD_ERR_OK) {

            $attachmentUrl = Helpers::handleFileUpload($_FILES['assignment_file']);

            if (!$attachmentUrl) {

                header("Location: create.php?id=$courseId&error=File upload failed");

                exit;
            }
        }

        $assignment = new Assignment();

        $result = $assignment->createAssignment($title, $description, $score, $attachmentUrl, $courseId);

        if ($result['status'] != 'error') {
            header("Location: index.php?message=Assignment added successfully");
            exit;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cloudease - Add Assignment</title>
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
                <header class="flex items-center justify-between p-6 bg-white shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-700">Add Assignment</h2>
                    <a href="index.php" class="text-blue-600 hover:underline">Back to Course</a>
                </header>

                <!-- Add assignment Form -->
                <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                        <!-- Title Field -->
                        <div class="mb-4">
                            <label for="assignment-title" class="block text-gray-700 font-medium">Assignment Title</label>
                            <input type="text" id="assignment-title" name="assignment_title"
                                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter title of the assignment" required>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-medium">Assignment Description</label>
                            <input type="hidden" id="description" name="description">
                            <div id="editor" style="height: 300px;"></div>
                        </div>

                        <div class="mb-4">
                            <label for="assignment-score" class="block text-gray-700 font-medium">Assignment Score</label>
                            <input type="number" id="assignment-score" name="assignment_score"
                                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter maximum score for the assignment" min="0" step="1" required>
                        </div>

                        <!-- File Upload Field -->
                        <div class="mb-4">
                            <label for="assignment-file" class="block text-gray-700 font-medium">Upload File, Video, PDF etc.</label>
                            <input type="file" id="assignment-file" name="assignment_file"
                                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="course-select" class="block text-gray-700 font-medium">Select Course</label>
                            <select id="course-select" name="course_id"
                                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                <option value="" disabled selected>Select a course</option>
                                    <?php foreach ($coursesData as $course) : ?>
                                <option value="<?= $course['course_id'] ?>"><?= $course['title'] ?></option>
                                <?php endforeach; ?>

                                <!-- Add more courses dynamically or statically -->
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Add Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <script src="../../public/assets/quill.js"></script>
    </body>
    </html>
