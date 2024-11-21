<?php

include 'vendor/autoload.php';

session_start();

use App\Authenticate;
// die(var_dump($_SESSION['access_token']));
// Initialize the Auth class
$auth = new Authenticate();

if (isset($_SESSION['access_token'])) {
    $auth->logoutUser($_SESSION['access_token']);
}

// Clear session data
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit();
?>
