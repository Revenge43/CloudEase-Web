<?php
    include '../../vendor/autoload.php';
    use App\Assignment;
    use App\Comments;
    use App\Helpers;

    session_start();

    $id = $_GET['id'];
    $courseId = $_GET['courseId'];
    $userId = $_SESSION['user']['user_id'];
    $assignment = new Assignment();
    $assignmentData = $assignment->getAssignments();
    $assignmentData = array_filter($assignmentData, function($assignment) use ($id) {
        return $assignment['id'] === $id;
    });

    $assignmentDataByCourseId = $assignment->getAssignment($id);
    $filePath = $assignmentDataByCourseId[0]['assignment_file'] ?? '';

    $comments = new Comments();
    $commentsData = $comments->getComments($courseId, $userId, $id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $text = $_POST['comment'] ?? null;
        $attachmentUrl = null;
        $userId = $_SESSION['user']['user_id'] ?? '';

        if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] === UPLOAD_ERR_OK) {
            $attachmentUrl = Helpers::handleFileUpload($_FILES['assignment_file']);
            if (!$attachmentUrl) {
                header("Location: show.php?id=$courseId&error=File upload failed");
                exit;
            }
        }

        if ($text != "") {
            $result = $comments->createComment($userId, $id, $text, $attachmentUrl, $courseId);
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
    <title>Cloudease - Assignments</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                
                <!-- Comment Form -->
                <form action="show.php?id=<?= $id ?>&courseId=<?= $courseId ?>" method="POST" class="mt-4" enctype="multipart/form-data">
                    <label for="comment" class="block text-gray-700 font-medium">Add a Comment</label>
                    <textarea id="comment" name="comment" rows="3" 
                            class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write your comment here..." required></textarea>

                    <button type="submit"
                            class="mt-3 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>

                    <!-- File Upload -->
                    <input type="file" id="assignment-file" name="assignment_file" class="w-80 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </form>

                <!-- Display Comments -->
                <div class="mt-6 comments-section"> <!-- Container for dynamically loaded comments -->
                    <?php foreach ($commentsData as $comment) : ?>
                        <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4 comment" id="comment-<?= $comment['id'] ?>">
                            <p class="text-gray-700">
                                <span class="font-semibold"><?= ucwords($comments->getUserName($comment['user_id'])) ?>:</span>
                                <?= $comment['text'] ?>
                            </p>
                            <p class="text-sm text-gray-500">Posted on: <?= date('M d, Y', strtotime($comment['timestamp'])); ?></p>

                            <!-- Check for attachment and display based on file type -->
                            <div class="mt-2">
                                <?php 
                                    $filePath = $comment['file'] ?? ''; // Assuming the file path is stored in 'file' column
                                    if ($filePath) {
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                                            // Image
                                            echo "<img src=\"$filePath\" alt=\"Comment Image\" class=\"w-full max-w-xs rounded-lg\">";
                                        } elseif (strtolower($fileExtension) === 'pdf') {
                                            // PDF
                                            echo "<a href=\"$filePath\" target=\"_blank\" class=\"text-blue-600 hover:underline\">View PDF Document</a>";
                                        } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) {
                                            // Word Document
                                            echo "<a href=\"$filePath\" target=\"_blank\" class=\"text-blue-600 hover:underline\">View Word Document</a>";
                                        } elseif (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])) {
                                            // Video
                                            echo "<a href=\"$filePath\" target=\"_blank\" class=\"text-blue-600 hover:underline\">View Video</a>";
                                        } else {
                                            echo "<p class=\"text-gray-500\">Unsupported file type</p>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            function fetchComments() {
                $.ajax({
                    url: 'fetch_comments.php', 
                    type: 'GET',
                    data: { id: <?= $id ?>, userId: <?= $userId ?>, courseId: <?= $courseId ?>},
                    success: function(data) {
                        const comments = JSON.parse(data);
                        let commentsHtml = '';
                        
                    // Loop through comments and build the HTML
                    $.each(comments, function(index, comment) {
                        let attachmentHtml = '';

                        // Check for image type attachment
                        if (comment.file && isImage(comment.file)) {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <img src="${comment.file}" alt="Comment Image" class="w-full max-w-xs rounded-lg">
                                </div>
                            `;
                        }
                        // Check for PDF attachment
                        else if (comment.file && isPDF(comment.file)) {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <a href="${comment.file}" target="_blank" class="text-blue-600 hover:underline">
                                        View PDF Document
                                    </a>
                                </div>
                            `;
                        }
                        // Check for Word attachment
                        else if (comment.file && isWordDocument(comment.file)) {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <a href="${comment.file}" target="_blank" class="text-blue-600 hover:underline">
                                        View Word Document
                                    </a>
                                </div>
                            `;
                        }
                        else if (comment.file && isVideo(comment.file)) {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <a href="${comment.file}" target="_blank" class="text-blue-600 hover:underline">
                                        View Video
                                    </a>
                                </div>
                            `;
                        }

                        commentsHtml += `
                            <div class="p-4 bg-gray-100 rounded-lg shadow-md mb-4 comment" id="comment-${comment.id}">
                                <p class="text-gray-700"><span class="font-semibold">${comment.user_name}:</span> ${comment.text}</p>
                                <p class="text-sm text-gray-500">Posted on: ${comment.timestamp}</p>
                                ${attachmentHtml} <!-- Here the attachment is inserted -->
                            </div>
                        `;
                    });


                        // Update comments section
                        $('.comments-section').html(commentsHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching comments: ", error);
                    }
                });
            }

            fetchComments();
            setInterval(fetchComments, 3000);

            // Function to check if a URL is an image
            function isImage(url) {
                return (/\.(jpg|jpeg|png|gif)$/i).test(url);
            }

            // Function to check if a URL is a PDF
            function isPDF(url) {
                return (/\.(pdf)$/i).test(url);
            }

            // Function to check if a URL is a Word document
            function isWordDocument(url) {
                return (/\.(docx?|doc)$/i).test(url);
            }

            function isVideo(url) {
                const videoExtensions = ['.mp4', '.avi', '.mov', '.mkv', '.webm', '.flv'];
                return videoExtensions.some(extension => url.toLowerCase().endsWith(extension));
            }
        });
    </script>
</body>
</html>
