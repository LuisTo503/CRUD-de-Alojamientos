<?php
include_once '../config/database.php';
include_once '../models/reservation_model.php';
include_once '../models/alojamiento_model.php';

class ReservationController {
    
    private $reservationModel;
    private $alojamientoModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->reservationModel = new ReservationModel($db);
        $this->alojamientoModel = new AlojamientoModel($db);
    }

    public function createReservation($data) {
        // Check if the accommodation is available
        $alojamiento = $this->alojamientoModel->read($data['alojamiento_id']);
        if (!$alojamiento['availability']) {
            echo "This accommodation is not available.";
            return false;
        }

        // Validate and sanitize input data
        $this->reservationModel->alojamiento_id = htmlspecialchars(strip_tags($data['alojamiento_id']));
        $this->reservationModel->user_id = $_SESSION['user_id'];
        $this->reservationModel->checkin = htmlspecialchars(strip_tags($data['checkin']));
        $this->reservationModel->checkout = htmlspecialchars(strip_tags($data['checkout']));
        $this->reservationModel->price = htmlspecialchars(strip_tags($data['price']));

        // Calculate total amount
        $checkin_date = new DateTime($data['checkin']);
        $checkout_date = new DateTime($data['checkout']);
        $interval = $checkin_date->diff($checkout_date);
        $days = $interval->days;
        $this->reservationModel->total_amount = $days * $data['price'];

        // Call the model method to create reservation
        if ($this->reservationModel->create()) {
            // Update accommodation availability
            $this->alojamientoModel->updateAvailability($data['alojamiento_id'], false);
            return true;
        }
        return false;
    }

    public function deleteReservation($id) {
        // Get the reservation details
        $reservation = $this->reservationModel->read($id);

        // Delete the reservation
        if ($this->reservationModel->delete($id)) {
            // Update accommodation availability
            $this->alojamientoModel->updateAvailability($reservation['alojamiento_id'], true);
            return true;
        }
        return false;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'create') {
                $this->createReservation($_POST);
                header("Location: ../views/dashboard.php");
                exit();
            } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
                $this->deleteReservation($_POST['reservation_id']);
                header("Location: ../views/dashboard.php");
                exit();
            }
        }
    }
}

session_start();
$controller = new ReservationController();
$controller->handleRequest();
?>