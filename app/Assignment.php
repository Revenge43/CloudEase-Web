<?php

namespace App;

use PDO;
use PDOException;
use App\Helpers;

class Assignment
{
    private $pdo;
    private $table = 'assignments';

    public function __construct()
    {
        $this->pdo = Helpers::getPDOConnection();
    }

    // Create an assignment
    public function createAssignment($title, $description, $score, $attachmentUrl, $courseId)
    {
        $sql = "INSERT INTO {$this->table} (assignment_title, assignment_description, assignment_score, assignment_file, course_id) 
                VALUES (:title, :description, :score, :attachmentUrl, :courseId)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':score', $score);
            $stmt->bindParam(':attachmentUrl', $attachmentUrl);
            $stmt->bindParam(':courseId', $courseId);

            $stmt->execute();
            return ['status' => 'success', 'message' => 'Assignment created successfully'];
        } catch (PDOException $e) {
            // Log error if the query fails
            error_log('Error creating assignment: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error creating assignment'];
        }
    }

    // Get all assignments
    public function getAssignments()
    {
        $sql = "SELECT * FROM {$this->table}";

        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error if the query fails
            error_log('Error fetching assignments: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error fetching assignments'];
        }
    }

    // Get assignments by course ID
    public function getAssignment($assignmentId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :assignment_id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':assignment_id', $assignmentId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error if the query fails
            error_log('Error fetching assignments: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error fetching assignments'];
        }
    }

    // Render the attachment based on the file type
    public function renderAttachment($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (in_array($extension, ['mp4', 'webm', 'mov'])) {
            return "<div class='mt-4 aspect-video'>
                        <video height='400' controls class='w-full rounded-md'>
                            <source src='" . htmlspecialchars($filePath) . "' type='video/$extension'>
                            Your browser does not support the video tag.
                        </video>
                          <center>
                        <a href='" . htmlspecialchars($filePath) . "' download target='_blank' class='mt-5 text-blue-600 hover:underline'>
                            Download
                        </a>
                    </center>
                    </div>";
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return "<div class='m-2 p-1 w-80'>
                       <a href='$filePath' download><img src='$filePath' alt='Attachment' class='w-full rounded-md'></a>
                    </div>";
        } elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
            return "<div class='mt-4'>
                        <audio controls class='w-full'>
                            <source src='" . htmlspecialchars($filePath) . "' type='audio/$extension'>
                            Your browser does not support the audio element.
                        </audio>
                    </div>";
        } elseif ($extension === 'pdf') {
            return "<div class='mt-4'>
                        <iframe src='" . htmlspecialchars($filePath) . "' class='w-full h-96 rounded-md'></iframe>
                    </div>";
        } else {
            return "<div class='mt-4'>
                        <a href='" . htmlspecialchars($filePath) . "' target='_blank' class='text-blue-600 hover:underline'>
                            Download File
                        </a>
                    </div>";
        }
    }
}
