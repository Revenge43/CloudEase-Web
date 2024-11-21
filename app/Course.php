<?php

namespace App;

use PDO;
use PDOException;
use App\Helpers;

class Course
{
    private $pdo;
    private $table = 'courses';
    private $storageUrl = 'https://your-storage-url.com/assets/'; // Assuming you still want to use a storage URL

    public function __construct()
    {
        $this->pdo = Helpers::getPDOConnection();
    }

    // Create a new course
    public function createCourse($title, $description, $image, $teacherId)
    {
        try {
            $sql = "INSERT INTO {$this->table} (title, description, image, teacher_id) VALUES (:title, :description, :image, :teacher_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':image' => $image,
                ':teacher_id' => $teacherId,
            ]);

            return ['success' => true, 'message' => 'Course created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }

    // Get all courses
    public function getCourses()
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error fetching courses: ' . $e->getMessage();
            return [];
        }
    }

    // Get a course by ID
    public function getCourse($courseId)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE course_id = :course_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error fetching course: ' . $e->getMessage();
            return [];
        }
    }

    // Delete a course by ID
    public function deleteCourse($courseId)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE course_id = :course_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);

            return ['success' => true, 'message' => 'Course deleted successfully'];
        } catch (PDOException $e) {
            echo 'Error deleting course: ' . $e->getMessage();
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Handle file upload (file handling is the same, but you can still use a URL for file storage)
     * @param array $file
     * @return string|null
     */
    public function handleFileUpload($file)
    {
        // Assuming you're using some external storage service or local file handling
        // Here, we will simulate a file upload URL
        $uploadPath = '/path/to/uploads/' . basename($file['name']); // Simulating storage path
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $this->storageUrl . basename($file['name']); // Returning the file URL
        } else {
            return null; // Return null if upload fails
        }
    }

    // Create a new module
    public function createModule($title, $description, $fileUrl, $courseId)
    {
        try {
            $sql = "INSERT INTO modules (module_title, module_description, module_file, course_id) VALUES (:module_title, :module_description, :module_file, :course_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':module_title' => $title,
                ':module_description' => $description,
                ':module_file' => $fileUrl,
                ':course_id' => $courseId,
            ]);

            return ['success' => true, 'message' => 'Module created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }

    // Create a new assignment
    public function createAssignment($title, $description, $score, $attachmentUrl, $courseId)
    {
        try {
            $sql = "INSERT INTO assignments (assingment_title, assignment_description, assignment_score, assignment_file, course_id) VALUES (:assingment_title, :assignment_description, :assignment_score, :assignment_file, :course_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':assingment_title' => $title,
                ':assignment_description' => $description,
                ':assignment_score' => $score,
                ':assignment_file' => $attachmentUrl,
                ':course_id' => $courseId,
            ]);

            return ['success' => true, 'message' => 'Assignment created successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }

    // Get modules by course ID
    public function getModuleById($courseId)
    {
        try {
            $sql = "SELECT * FROM modules WHERE course_id = :course_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Error fetching modules: ' . $e->getMessage();
            return [];
        }
    }
}
