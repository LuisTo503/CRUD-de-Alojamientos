<?php
class AlojamientoModel {
    private $conn;
    private $table_name = "alojamientos";

    public $id;
    public $user_id;
    public $name;
    public $description;
    public $location;
    public $price;
    public $rooms;
    public $availability;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, name=:name, description=:description, location=:location, price=:price, rooms=:rooms, availability=:availability, image=:image";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":rooms", $this->rooms);
        $stmt->bindParam(":availability", $this->availability);
        $stmt->bindParam(":image", $this->image);

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

    public function read($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, location = :location, price = :price, rooms = :rooms, availability = :availability, image = :image WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":rooms", $this->rooms);
        $stmt->bindParam(":availability", $this->availability);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateAvailability($id, $availability) {
        $query = "UPDATE " . $this->table_name . " SET availability = :availability WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":availability", $availability);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>