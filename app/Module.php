<?php

namespace App;

use GuzzleHttp\Client;

class Module
{
    private $client;
    private $apiUrl = 'https://onvatnocrobzlxendxxd.supabase.co';
    private $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzEyODA1NzIsImV4cCI6MjA0Njg1NjU3Mn0.176GaFj20la7dBxTiYU_iHU4WLt0LDV_iLGMSpFElhQ';
    private $table = 'modules';

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
            $response = $this->client->post("/rest/v1/{$this->table}", [
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
            $response = $this->client->get("/rest/v1/{$this->table}?course_id=eq.{$courseId}");
            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            echo 'Error fetching courses: ' . $e->getMessage();

            return [];
        }
    }
}