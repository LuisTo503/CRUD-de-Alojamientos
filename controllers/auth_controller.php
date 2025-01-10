<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../models/user_model.php';
include_once '../config/database.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
    }

    public function login($username, $password) {
        // Validate user credentials
        $user = $this->userModel->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Start session and set user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }

    public function register($username, $password, $email, $role = 'user') {
        // Hash the password and save the user
        $this->userModel->username = htmlspecialchars(strip_tags($username));
        $this->userModel->password = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->email = htmlspecialchars(strip_tags($email));
        $this->userModel->role = $role;
        return $this->userModel->create();
    }
}

$authController = new AuthController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $authController->login($_POST['username'], $_POST['password']);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        $authController->register($_POST['username'], $_POST['password'], $_POST['email']);
        header("Location: ../views/login.php");
        exit();
    }
}
?>