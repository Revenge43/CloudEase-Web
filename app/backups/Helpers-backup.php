<?php
namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class Helpers
{
    private static $serviceRoleKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9udmF0bm9jcm9iemx4ZW5keHhkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTczMTI4MDU3MiwiZXhwIjoyMDQ2ODU2NTcyfQ.1Z3Xjww_hEek6Qq3rNGu-7BQuqnMOZ5D2GG11XxRuME';
    private static $storageUrl = 'https://onvatnocrobzlxendxxd.supabase.co/storage/v1/object/';

     /**
     * Handle file upload to Supabase storage
     *
     * @param array $file
     * @return string|null
     */
    public static function handleFileUpload($file)
    {
        try {

            $fileTmpPath = $file['tmp_name'];
            $originalFileName = basename($file['name']);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

            $hashedFileName = md5(uniqid() . time()) . '.' . $fileExtension;

            $supabasePath = $hashedFileName;

            $uploadClient = new Client([
                'base_uri' => self::$storageUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$serviceRoleKey,
                ],
            ]);

            $response = $uploadClient->post("assets/{$supabasePath}", [
                'body' => fopen($fileTmpPath, 'r'),
                'headers' => [
                    'Content-Type' => mime_content_type($fileTmpPath),
                ],
            ]);

            fclose(fopen($fileTmpPath, 'r'));

            if ($response->getStatusCode() === 200) {

                $url = self::$storageUrl . "public/assets/{$supabasePath}";
                return $url;
            }

            error_log('Upload failed with status: ' . $response->getStatusCode());
            error_log($response->getBody()->getContents());

            return null;

        } catch (RequestException $e) {

            error_log('Error uploading file: ' . $e->getMessage());
            error_log(print_r($e->getResponse()->getBody()->getContents(), true));

            return null;
        }
    }
}