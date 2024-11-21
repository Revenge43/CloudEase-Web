<?php
include 'vendor/autoload.php';

use App\Authenticate;
use Components\SidebarComponent;
use Components\HeaderComponent;

class LoginPage {

    public function __construct() {
        $this->handleLogin();
        $this->render();
    }

    public function handleLogin() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Authenticate();

            try {
                $response = $auth->loginUser($email, $password);
                $auth = new Authenticate();
                session_start();

                if ($response['status'] == 200) {
                    $_SESSION['access_token']       =  $response['access_token'] ?? '';
                    $_SESSION['userInfo']           =  $auth->getUserInfo($_SESSION['access_token']);
                    $_SESSION['user'] = $response['user'];
                    $_SESSION['SidebarComponent']   =  SidebarComponent::render();
                    $_SESSION['HeaderComponent']    =  HeaderComponent::render();
                } else {
                    header("Location: index.php?error=" . $response['message']);
                }
                
                if (isset($response['redirect'])) {

                    header("Location: " . $response['redirect']);

                    exit;

                } elseif (isset($response['error'])) {

                    echo "<script>
                            document.getElementById('error-message').textContent = '{$response['error']}';
                            document.getElementById('error-message').style.display = 'block';
                        </script>";
                }
            } catch (Exception $e) {
                die($e);

                header("Location: index.php?error=" . urlencode("An error occurred: " . $e->getMessage()));

                exit;
            }
        }
    }

    public function render() {
        echo <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Login - Cloudease</title>
                <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
            </head>
                <body class="bg-gray-100">
                    <div class="flex items-center justify-center min-h-screen mt-10">
                        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
                            <h2 class="text-2xl font-semibold text-center text-gray-700">Cloudease</h2>
                            <form id="login" action="{$_SERVER['PHP_SELF']}" method="post">
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                    <input type="email" id="email" name="email" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="you@example.com">
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" id="password" name="password" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="••••••••">
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <input id="remember" type="checkbox"
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                                    </div>
                                    <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                                </div>
                                <div id="error-message" class="mb-4 text-red-600 text-sm" style="display: none;"></div>
                                <button type="submit"
                                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                    Sign in
                                </button>
                            </form>
                            <p class="mt-6 text-sm text-center text-gray-600">
                                Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Sign up</a>
                            </p>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
                </body>
            </html>
        HTML;
    }
}

new LoginPage();
