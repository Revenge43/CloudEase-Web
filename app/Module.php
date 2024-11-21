<?php

namespace App;

use PDO;
use PDOException;
use App\Helpers;

class Module
{
    private $pdo;
    private $tableModules = 'modules';
    private $tableTopics = 'module_topics';

    public function __construct()
    {
        $this->pdo = Helpers::getPDOConnection();
    }

    /**
     * Create a new module
     * @param string $title
     * @param string $description
     * @param int $courseId
     * @return array|string
     */
    public function createModule($title, $description, $courseId)
    {
        try {
            $sql = "INSERT INTO {$this->tableModules} (module_title, module_description, course_id)
                    VALUES (:title, :description, :courseId)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':courseId', $courseId);
            $stmt->execute();

            return [
                'success' => true,
                'id' => $this->pdo->lastInsertId(),
                'message' => 'Module created successfully.'
            ];
        } catch (PDOException $e) {
            return 'Error creating module: ' . $e->getMessage();
        }
    }

    /**
     * Fetch a module by course ID
     * @param int $courseId
     * @return array
     */
    public function getModuleById($courseId)
    {
        try {
            $sql = "SELECT * FROM {$this->tableModules} WHERE course_id = :courseId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':courseId', $courseId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return 'Error fetching modules: ' . $e->getMessage();
        }
    }

    /**
     * Create a topic for a module
     * @param string $title
     * @param string $description
     * @param int $moduleId
     * @param string $attachmentUrl
     * @return array|string
     */
    public function createModuleTopic($title, $description, $moduleId, $attachmentUrl)
    {
        try {
            $sql = "INSERT INTO {$this->tableTopics} (title, description, module_id, attachment)
                    VALUES (:title, :description, :moduleId, :attachment)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':moduleId', $moduleId);
            $stmt->bindParam(':attachment', $attachmentUrl);

            $stmt->execute();

            return [
                'success' => true,
                'id' => $this->pdo->lastInsertId(),
                'message' => 'Module topic created successfully.'
            ];

        } catch (PDOException $e) {

            return 'Error creating module topic: ' . $e->getMessage();
        }
    }

    public function getModuleTopics($moduleId)
    {
        try {
            $sql = "SELECT * FROM {$this->tableTopics} WHERE module_id = :moduleId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':moduleId', $moduleId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch topics as associative array
        } catch (PDOException $e) {
            return 'Error fetching topics: ' . $e->getMessage();
        }
    }
}
