<?php

include 'vendor/autoload.php';

session_start();

use App\Auth;
// die(var_dump($_SESSION['access_token']));
// Initialize the Auth class
$auth = new Auth();

// Revoke the token with Supabase (optional)
if (isset($_SESSION['access_token'])) {
    $auth->logoutUser();
}

// Clear session data
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit();
?>
