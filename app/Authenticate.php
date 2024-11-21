<?php
namespace App;

use PDO;
use PDOException;
use App\Helpers;

class Authenticate {
    private $pdo;

    public function __construct() {
        
        $this->pdo = Helpers::getPDOConnection();
    }

    public function signUpUser($email, $password, $name, $role) {
        try {
            // Check if user already exists
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return ['error' => 'User already exists.'];
            }

            // Insert new user
            $stmt = $this->pdo->prepare("INSERT INTO users (email, password, name, role) VALUES (:email, :password, :name, :role)");
            $stmt->execute([
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT), // Hash password
                'name' => $name,
                'role' => strtolower($role)
            ]);

            // Return success message
            return ['success' => 'User created successfully.'];

        } catch (PDOException $e) {
            return ['error' => 'An error occurred while signing up: ' . $e->getMessage()];
        }
    }

    public function loginUser($email, $password) {
        try {
            // Fetch user from database
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return [
                    'status' => 401,
                    'message' => 'Invalid email or password.'
                ];
            }

            // Generate access token (could be a simple JWT token, for example)
            $accessToken = bin2hex(random_bytes(32)); // Simple token generation

            return [
                'user' => $user,
                'status' => 200,
                'redirect' => 'pages/dashboard.php',
                'access_token' => $accessToken,
            ];

        } catch (PDOException $e) {
            
            return ['error' => 'An error occurred while logging in: ' . $e->getMessage()];
        }
    }

    public function getUserInfo($accessToken) {
        try {
            // Assuming you store the access token in the session or similar
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE access_token = :access_token");
            $stmt->execute(['access_token' => $accessToken]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['error' => 'Invalid access token.'];
            }

            return $user;

        } catch (PDOException $e) {
            return ['error' => 'An error occurred while fetching user info: ' . $e->getMessage()];
        }
    }

    public function logoutUser($accessToken) {
        try {
            // Here we would ideally invalidate the access token, for simplicity assume we delete it
            $stmt = $this->pdo->prepare("UPDATE users SET access_token = NULL WHERE access_token = :access_token");
            $stmt->execute(['access_token' => $accessToken]);

            return [
                'status' => 200,
                'message' => 'Logout successful.'
            ];

        } catch (PDOException $e) {
            return [
                'status' => 500,
                'message' => 'An error occurred during logout: ' . $e->getMessage()
            ];
        }
    }
}
?>
