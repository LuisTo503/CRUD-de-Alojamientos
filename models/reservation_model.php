<?php
class ReservationModel {
    private $conn;
    private $table_name = "reservations";

    public $id;
    public $alojamiento_id;
    public $user_id;
    public $checkin;
    public $checkout;
    public $price;
    public $total_amount;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET alojamiento_id=:alojamiento_id, user_id=:user_id, checkin=:checkin, checkout=:checkout, price=:price, total_amount=:total_amount";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":alojamiento_id", $this->alojamiento_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":checkin", $this->checkin);
        $stmt->bindParam(":checkout", $this->checkout);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":total_amount", $this->total_amount);

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

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>