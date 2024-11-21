<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Course
{
    private $client;
    private $apiUrl = 'https://onvatnocrobzlxendxxd.supabase.co';
    private $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzEyODA1NzIsImV4cCI6MjA0Njg1NjU3Mn0.176GaFj20la7dBxTiYU_iHU4WLt0LDV_iLGMSpFElhQ';
    private $serviceRoleKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTczMTI4MDU3MiwiZXhwIjoyMDQ2ODU2NTcyfQ.1Z3Xjww_hEek6Qq3rNGu-7BQuqnMOZ5D2GG11XxRuME';
    private $table = 'courses';
    private $storageUrl = 'https://onvatnocrobzlxendxxd.supabase.co/storage/v1/object/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createCourse($title, $description, $image, $teacherId)
    {
        try {

            $response = $this->client->post("/rest/v1/{$this->table}", [
                'json' => [
                    'title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'teacher_id' => $teacherId
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @return array
     */
    public function getCourses()
    {
        try {

            $response = $this->client->get("/rest/v1/{$this->table}");
            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Error fetching courses: ' . $e->getMessage();
            return [];
        }
    }

    /**
     * @return array
     */
    public function getCourse($courseId)
    {
        try {

            $response = $this->client->get("/rest/v1/{$this->table}?course_id=eq.{$courseId}");

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            echo 'Error fetching courses: ' . $e->getMessage();

            return [];
        }
    }

    public function deleteCourse($courseId)
    {
        try {
           $this->client->delete("/rest/v1/courses/{course_id}");

            return false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Error deleting course: ' . $e->getMessage();
            echo "Response Body: " . $e->getResponse()->getBody();
            return false;
        }
    }

    /**
     * Handle file upload to Supabase storage
     *
     * @param array $file The uploaded file information
     * @return string|null The public URL of the uploaded file or null on failure
     */
    public function handleFileUpload($file)
    {
        try {
            // Temporary file path and original file name
            $fileTmpPath = $file['tmp_name'];
            $originalFileName = basename($file['name']);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

            // Generate a unique filename
            $hashedFileName = md5(uniqid() . time()) . '.' . $fileExtension;

            // Supabase path (relative to the bucket)
            $supabasePath = $hashedFileName;

            // Create a new Guzzle client instance
            $uploadClient = new Client([
                'base_uri' => $this->storageUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->serviceRoleKey, // Use the Service Role Key
                ],
            ]);

            // Upload the file to Supabase Storage
            $response = $uploadClient->post("assets/{$supabasePath}", [
                'body' => fopen($fileTmpPath, 'r'),
                'headers' => [
                    'Content-Type' => mime_content_type($fileTmpPath),
                ],
            ]);

            // Close the file handle to free resources
            fclose(fopen($fileTmpPath, 'r'));

            // Check the response
            if ($response->getStatusCode() === 200) {
                // Return the public URL of the uploaded file
                $url = $this->storageUrl . "public/assets/{$supabasePath}";
                return $url;
            }

            error_log('Upload failed with status: ' . $response->getStatusCode());
            error_log($response->getBody()->getContents());
            return null;

        } catch (RequestException $e) {
            // Log any exceptions during the upload process
            error_log('Error uploading file: ' . $e->getMessage());
            error_log(print_r($e->getResponse()->getBody()->getContents(), true));
            return null;
        }
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $attachmentUrl
     * @param string $teacherId
     * @return array|string
     */
    public function createModule($title, $description, $fileUrl, $courseId)
    {
        $payload = [
            'module_title' => $title,
            'module_description' => $description,
            'module_file' => $fileUrl,
            'course_id' => $courseId,
        ];

        try {
            $response = $this->client->post("/rest/v1/modules", [
                'json' => $payload,
            ]);

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            error_log('Error creating module: ' . $e->getMessage());
            error_log('Response: ' . $responseBody);
            return 'Error: ' . $responseBody;
        }
    }

    public function createAssignment($title, $description, $score, $attachmentUrl, $courseId) {
        $payload = [
            'assingment_title' => $title,
            'assignment_description' => $description,
            'assignment_score' => $score,
            'assignment_file' => $attachmentUrl,
            'course_id' => $courseId,
        ];

        try {
            $response = $this->client->post("/rest/v1/assignments", [
                'json' => $payload,
            ]);

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            error_log('Error creating module: ' . $e->getMessage());
            error_log('Response: ' . $responseBody);
            return 'Error: ' . $responseBody;
        }
    }

     /**
     * @return array
     */
    public function getModuleById($courseId)
    {
        try {
            $response = $this->client->get("/rest/v1/modules?course_id=eq.{$courseId}");

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            
            echo 'Error fetching courses: ' . $e->getMessage();

            return [];
        }
    }
}