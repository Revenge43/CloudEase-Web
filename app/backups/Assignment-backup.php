<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Assignment
{
    private $client;
    private $apiUrl = 'https://onvatnocrobzlxendxxd.supabase.co';
    private $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzEyODA1NzIsImV4cCI6MjA0Njg1NjU3Mn0.176GaFj20la7dBxTiYU_iHU4WLt0LDV_iLGMSpFElhQ';
    private $table = 'assignments';

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

    public function createAssignment($title, $description, $score, $attachmentUrl, $courseId)
    {
        $payload = [
            'assignment_title' => $title,
            'assignment_description' => $description,
            'assignment_score' => $score,
            'assignment_file' => $attachmentUrl,
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
    public function getAssignments()
    {
        try {
            $response = $this->client->get("/rest/v1/{$this->table}", [
                'query' => [
                    'select' => '*',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            error_log('Error fetching assignments: ' . $e->getMessage());
            error_log('Response: ' . $responseBody);
            return 'Error: ' . $responseBody;
        }
    }

    /**
     * @param string $courseId
     * @return array
     */
    public function getAssignment($courseId)
    {
        try {

            $response = $this->client->get("/rest/v1/{$this->table}?course_id=eq.{$courseId}");

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            echo 'Error fetching courses: ' . $e->getMessage();

            return [];
        }
    }

    /**
     * @return
     */
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
                        <a href='<?= htmlspecialchars($filePath) ?>' download target='_blank' class='mt-5 text-blue-600 hover:underline'>
                            Download
                        </a>
                    </center>
                    </div>";
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return "<div class='mt-4'>
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
