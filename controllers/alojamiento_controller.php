<?php
include_once '../config/database.php';
include_once '../models/alojamiento_model.php';

class AlojamientoController {
    private $alojamientoModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->alojamientoModel = new AlojamientoModel($db);
    }

    public function createOrUpdateAlojamiento($data, $file) {
        $this->alojamientoModel->user_id = $_SESSION['user_id'];
        $this->alojamientoModel->name = htmlspecialchars(strip_tags($data['name']));
        $this->alojamientoModel->description = htmlspecialchars(strip_tags($data['description']));
        $this->alojamientoModel->location = htmlspecialchars(strip_tags($data['location']));
        $this->alojamientoModel->price = htmlspecialchars(strip_tags($data['price']));
        $this->alojamientoModel->rooms = htmlspecialchars(strip_tags($data['rooms']));
        $this->alojamientoModel->availability = htmlspecialchars(strip_tags($data['availability']));

        if ($file['image']['name']) {
            $target_dir = "../assets/images/";
            $target_file = $target_dir . basename($file["image"]["name"]);
            move_uploaded_file($file["image"]["tmp_name"], $target_file);
            $this->alojamientoModel->image = basename($file["image"]["name"]);
        } else {
            $this->alojamientoModel->image = isset($data['image']) ? $data['image'] : null;
        }

        if (isset($data['id']) && !empty($data['id'])) {
            $this->alojamientoModel->id = $data['id'];
            return $this->alojamientoModel->update();
        } else {
            return $this->alojamientoModel->create();
        }
    }

    public function deleteAlojamiento($id) {
        return $this->alojamientoModel->delete($id);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'delete') {
                $this->deleteAlojamiento($_POST['id']);
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                $this->createOrUpdateAlojamiento($_POST, $_FILES);
                header("Location: ../views/dashboard.php");
                exit();
            }
        }
    }
}

session_start();
$controller = new AlojamientoController();
$controller->handleRequest();
?>