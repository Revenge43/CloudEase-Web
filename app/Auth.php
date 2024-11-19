<?php
namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Auth {
    private $client;
    private $urlBase;
    private $apiKey;

    public function __construct() {
        $this->urlBase = 'https://onvatnocrobzlxendxxd.supabase.co/';
        $this->apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzEyODA1NzIsImV4cCI6MjA0Njg1NjU3Mn0.176GaFj20la7dBxTiYU_iHU4WLt0LDV_iLGMSpFElhQ'; // Supabase service role API key
        $this->client = new Client();
    }

    public function signUpUser($email, $password, $name, $role) {
        try {

            $response = $this->client->post($this->urlBase . 'auth/v1/signup', [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ],
                'headers' => [
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['access_token'])) {

                 $this->insertRoleInUsersTable($email, $name, $role);

            } else {

                return ['error' => 'Sign-up failed.'];
            }

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMsg = isset($responseBody['msg']) ? $responseBody['msg'] : 'An error occurred';
            $response = ['error' => $errorMsg];

            return $response;
        }
    }

    private function insertRoleInUsersTable($email, $name, $role) {
        try {
            $response = $this->client->post($this->urlBase . 'rest/v1/users', [
                'json' => [
                    'email' => $email,
                    'name'  => $name,
                    'role'  => strtolower($role)
                ],
                'headers' => [
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if($data) {

                header("Location: index.php?success=User created successfully");
            }

        } catch (RequestException $e) {

            return ['error' => 'An error occurred while inserting the role: ' . $e->getMessage()];
        }
    }

    public function loginUser($email, $password) {
        try {

            $response = $this->client->post($this->urlBase . 'auth/v1/token?grant_type=password', [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ],
                'headers' => [
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['access_token'])) {

                return [
                    'status' => 200,
                    'redirect' => 'pages/dashboard.php',
                    'access_token' => $data['access_token'],
                ];
            } else {
                return [
                    'status' => 401,
                    'message' => 'Invalid email or password.'
                ];
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMsg = isset($responseBody['msg']) ? $responseBody['msg'] : 'An error occurred';
            $response = ['error' => $errorMsg];

            return $response;
        }
    }

    public function getUserInfo($accessToken) {
        try {

            $response = $this->client->request('GET', "{$this->urlBase}auth/v1/user", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle the error by returning a meaningful message
            return ['error' => $e->getMessage()];
        }
    }

    public function logoutUser() {
        try {
            $response = $this->client->post($this->urlBase . 'auth/v1/logout', [
                'headers' => [
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            if ($response->getStatusCode() === 204) {
                return [
                    'status' => 200,
                    'message' => 'Logout successful.'
                ];
            } else {
                return [
                    'status' => 500,
                    'message' => 'Failed to log out.'
                ];
            }

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errorMsg = $e->getMessage();
            return [
                'status' => 500,
                'message' => 'An error occurred during logout: ' . $errorMsg
            ];
        }
    }
}
?>
