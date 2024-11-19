<?php
include 'vendor/autoload.php';

use App\Auth;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($password !== $confirmPassword) {

        header("Location: register.php?error=" . urlencode("Passwords do not match"));
        exit;
    }

    $auth = new Auth();

    try {

        $response = $auth->signUpUser($email, $password, $name, $role);

    } catch (Exception $e) {

        header("Location: register.php?error=" . urlencode($e->getMessage()));
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cloudease</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen mt-10">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center text-gray-700">Register for Cloudease</h2>
            <?php
            if (isset($response['error'])): ?>
                <div class="flex items-center mt-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <?= isset($response['error']) ? htmlspecialchars($response['error']) : '' ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
                $oldName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
                $oldEmail = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
                $oldRole = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';
                echo $oldRole;
            ?>
           <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" class="mt-6">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= $oldName; ?>" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Your name">
                </div>

                <!-- Email input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input type="email" id="email" name="email" value="<?= $oldEmail; ?>" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="you@example.com">
                </div>

                <!-- Password input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="••••••••">
                </div>

                <!-- Confirm Password input -->
                <div class="mb-4">
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="••••••••">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" required
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Role</option>
                        <option value="admin" <?= ($oldRole === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="student" <?= ($oldRole === 'student') ? 'selected' : ''; ?>>Student</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Sign up
                </button>
            </form>

            <!-- Sign in link -->
            <p class="mt-6 text-sm text-center text-gray-600">
                Already have an account? <a href="index.php" class="text-blue-600 hover:underline">Sign in</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
