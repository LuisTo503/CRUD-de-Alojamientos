<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $email;
    public $balance;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password, email=:email, balance=:balance, role=:role";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->balance = htmlspecialchars(strip_tags($this->balance));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $this->balance = $row['balance'];
            $this->role = $row['role'];
            $this->created_at = $row['created_at'];
            return $row;
        }

        return null;
    }

    public function updateBalance($id, $amount) {
        $query = "UPDATE " . $this->table_name . " SET balance = balance + :amount WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>