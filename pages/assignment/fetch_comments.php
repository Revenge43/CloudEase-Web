<?php
    include '../../vendor/autoload.php';
    use App\Comments;

    $id = $_GET['id'];

    $comments = new Comments();
    $userId = $_GET['userId'];
    $courseId = $_GET['courseId'];

    $commentsData = $comments->getComments($courseId, $userId, $id);

    $commentsList = [];
    foreach ($commentsData as $comment) {
        $commentsList[] = [
            'id' => $comment['id'],
            'user_name' => ucwords($comments->getUserName($comment['user_id'])),
            'text' => $comment['text'],
            'timestamp' => date('M d, Y', strtotime($comment['timestamp'])),
            'file' => $comment['file'] ?? ''
        ];
    }

    echo json_encode($commentsList);
?>
