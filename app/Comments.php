<?php

namespace App;

use GuzzleHttp\Client;

class Comments
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

    public function createComment($courseId, $assignmentId, $comment)
    {
        try {

            $response = $this->client->post("/rest/v1/comments", [
                'json' => [
                    'course_id' => $courseId,
                    'assignment_id' => $assignmentId,
                    'comment' => $comment,
                ],
            ]);

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $responseBody = $e->getResponse()->getBody()->getContents();
            error_log('Error creating comment: ' . $e->getMessage());
            error_log('Response: ' . $responseBody);
            return 'Error: ' . $responseBody;
        }
    }

    /**
     * @return array
     */
    public function getComments()
    {
        try {
            $response = $this->client->get("/rest/v1/comments");

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Error fetching comments: ' . $e->getMessage();
            return [];
        }
    }

    public function getUsername($userId)
    {
        try {
            $response = $this->client->get("/rest/v1/users?user_id=eq.{$userId}");

            return json_decode($response->getBody(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Error fetching user: ' . $e->getMessage();
            return [];
        }
    }
}
