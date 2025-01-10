<?php
/*class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password, email=:email";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->email = $row['email'];
            $this->created_at = $row['created_at'];
            return $row;
        }

        return null;
    }
}*/
include_once '../models/user_model.php';
include_once '../config/database.php';

class UserController {
    
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
    }

    public function createUser($data) {
        // Validate and sanitize input data
        $this->userModel->username = htmlspecialchars(strip_tags($data['username']));
        $this->userModel->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->userModel->email = htmlspecialchars(strip_tags($data['email']));

        // Call the model method to create user
        return $this->userModel->create();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
            $this->createUser($_POST);
            header("Location: ../views/dashboard.php");
            exit();
        }
    }
}

$controller = new UserController();
$controller->handleRequest();
?>