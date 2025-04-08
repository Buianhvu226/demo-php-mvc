<?php
class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate input
            $errors = [];

            if (empty($username)) {
                $errors[] = "Username is required";
            }

            if (empty($email)) {
                $errors[] = "Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }

            if (empty($password)) {
                $errors[] = "Password is required";
            } elseif (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters";
            }

            if ($password !== $confirmPassword) {
                $errors[] = "Passwords do not match";
            }

            // Check if username or email already exists
            if ($this->userModel->findByUsername($username)) {
                $errors[] = "Username already exists";
            }

            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email already exists";
            }

            if (empty($errors)) {
                // Register user
                if ($this->userModel->register($username, $email, $password)) {
                    $_SESSION['message'] = "Registration successful! Please log in.";
                    $_SESSION['message_type'] = "success";
                    header("Location: " . BASE_URL . "/auth/login");
                    exit;
                } else {
                    $errors[] = "Registration failed. Please try again.";
                }
            }

            // If there are errors, show them
            $_SESSION['errors'] = $errors;
        }

        $pageTitle = 'Register';
        $contentView = 'views/auth/register.php';

        include 'views/application.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate input
            $errors = [];

            if (empty($username)) {
                $errors[] = "Username is required";
            }

            if (empty($password)) {
                $errors[] = "Password is required";
            }

            if (empty($errors)) {
                // Attempt login
                $user = $this->userModel->login($username, $password);

                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['message'] = "Login successful!";
                    $_SESSION['message_type'] = "success";
                    header("Location: " . BASE_URL . "/tasks");
                    exit;
                } else {
                    $errors[] = "Invalid username or password";
                }
            }

            $_SESSION['errors'] = $errors;
        }

        $pageTitle = 'Login';
        $contentView = 'views/auth/login.php';

        include 'views/application.php';
    }

    public function logout()
    {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }
}
