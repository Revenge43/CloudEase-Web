<?php
namespace App;

use PDO;
use PDOException;
use App\Helpers;

class Comments
{
    private $pdo;
    private $table = 'comments';

    public function __construct()
    {
        $this->pdo = Helpers::getPDOConnection();
    }

    public function createComment($userId, $assignmentId, $text, $attachmentUrl, $courseId)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (course_id, user_id, assignment_id, text, file) VALUES (:course_id, :user_id, :assignment_id, :text, :file)");
            $stmt->bindParam(':course_id', $courseId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':assignment_id', $assignmentId);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':file', $attachmentUrl);

            $stmt->execute();

            return ['message' => 'Comment created successfully'];
        } catch (PDOException $e) {
            error_log('Error creating comment: ' . $e->getMessage());
            return ['error' => 'Error creating comment: ' . $e->getMessage()];
        }
    }

    public function getComments($course_id, $userId, $assignmentId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE course_id = :course_id AND user_id = :user_id AND assignment_id = :assignment_id");
            $stmt->bindParam(':course_id', $course_id);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':assignment_id', $assignmentId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error fetching comments: ' . $e->getMessage();
            return [];
        }
    }

    public function getUsername($userId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT name FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
        } catch (PDOException $e) {
            echo 'Error fetching user: ' . $e->getMessage();
            return [];
        }
    }
}
