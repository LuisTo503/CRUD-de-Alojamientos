<?php
include_once '../config/database.php';
include_once '../models/reservation_model.php';

$database = new Database();
$db = $database->getConnection();

$reservationModel = new ReservationModel($db);
$reservation = $reservationModel->read($_GET['id']);

if ($reservation) {
    if ($reservationModel->delete($_GET['id'])) {
        echo "Reservation deleted successfully.";
    } else {
        echo "Failed to delete reservation.";
    }
} else {
    echo "Reservation not found.";
}
?>