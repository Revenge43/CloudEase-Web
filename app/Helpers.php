<?php
namespace App;

use Exception;
use PDO;
use PDOException;

class Helpers
{
    private static $host = 'localhost';
    private static $db = 'cloudease';
    private static $user = 'root';
    private static $password = ''; // Empty password for local environment

    private static $storageDirectory = '../../uploads/'; // Directory where files will be stored

    /**
     * Handle file upload and store file information in MySQL database
     *
     * @param array $file
     * @return string|null
     */
    public static function handleFileUpload($file)
    {
        try {
            // Check if the file is uploaded properly
            if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
                error_log('No file uploaded or invalid file.');
                return null;
            }

            $fileTmpPath = $file['tmp_name'];
            $originalFileName = basename($file['name']);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

            // Generate a hashed file name to avoid collisions
            $hashedFileName = md5(uniqid() . time()) . '.' . $fileExtension;

            // Ensure the uploads directory exists
            if (!file_exists(self::$storageDirectory)) {
                mkdir(self::$storageDirectory, 0777, true); // Create directory if it doesn't exist
            }

            // Determine the file path to store in the server
            $filePath = self::$storageDirectory . $hashedFileName;


            // Debugging: Log the file paths
            error_log('Temporary file path: ' . $fileTmpPath);
            error_log('Target file path: ' . $filePath);

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                // Return the URL of the uploaded file
                return $filePath;
            } else {
                error_log('Failed to move the uploaded file.');
                return null;
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return null;
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get PDO connection to the database
     *
     * @return PDO
     */
    public static function getPDOConnection()
    {
        $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db . ';charset=utf8';
        try {
            $pdo = new PDO($dsn, self::$user, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
