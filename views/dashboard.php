<?php
include_once '../config/database.php';
include_once '../models/alojamiento_model.php';
include_once '../models/user_model.php';
include_once '../models/reservation_model.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$alojamientoModel = new AlojamientoModel($db);
$userModel = new User($db);
$reservationModel = new ReservationModel($db);

$alojamientos = $alojamientoModel->readAll();
$users = $userModel->readAll();
$reservations = $reservationModel->readAll();

function updateBalance($userModel, $reservations) {
    foreach ($reservations as $reservation) {
        $checkin_date = new DateTime($reservation['checkin']);
        $checkout_date = new DateTime($reservation['checkout']);
        $current_date = new DateTime();

        if ($checkout_date < $current_date) {
            $userModel->updateBalance($reservation['user_id'], -$reservation['total_amount']);
        } else {
            $userModel->updateBalance($reservation['user_id'], $reservation['total_amount']);
        }
    }
}

updateBalance($userModel, $reservations);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Noto Serif', serif;
        }
        .card-title {
            font-family: 'Noto Serif', serif;
            color: #333;
        }
        .card-text {
            color: #555;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="container">
        <h1>Bienvenido al Dashboard</h1>
        <p>Aquí puedes gestionar alojamientos y usuarios.</p>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <h2>Gestión de Alojamientos</h2>
            <a href="alojamiento_form.php" class="btn btn-primary mb-3">Agregar Nuevo Alojamiento</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Ubicación</th>
                        <th>Precio</th>
                        <th>Habitaciones</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alojamientos as $alojamiento): ?>
                        <tr>
                            <td><img src="../assets/images/<?php echo $alojamiento['image']; ?>" alt="<?php echo $alojamiento['name']; ?>" style="width: 100px; height: 100px;"></td>
                            <td><?php echo $alojamiento['name']; ?></td>
                            <td><?php echo $alojamiento['description']; ?></td>
                            <td><?php echo $alojamiento['location']; ?></td>
                            <td>$<?php echo $alojamiento['price']; ?></td>
                            <td><?php echo $alojamiento['rooms']; ?></td>
                            <td><?php echo $alojamiento['availability'] ? 'Disponible' : 'No disponible'; ?></td>
                            <td>
                                <a href="alojamiento_form.php?id=<?php echo $alojamiento['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="../controllers/alojamiento_controller.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $alojamiento['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="alojamiento_form.php?id=<?php echo $alojamiento['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Gestión de Usuarios</h2>
            <a href="user_form.php" class="btn btn-primary mb-3">Agregar Nuevo Usuario</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Email</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td style="color: <?php echo ($user['balance'] < 0) ? 'gray' : 'black'; ?>">
                                $<?php echo $user['balance']; ?>
                                <?php if ($user['balance'] < 0): ?>
                                    <span>(Saldo anterior cancelado)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Total de Ventas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Total de Ventas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            $total_sales = 0;
                            foreach ($reservations as $reservation) {
                                $total_sales += $reservation['total_amount'];
                            }
                            echo '$' . $total_sales;
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <h2>Alojamientos Disponibles</h2>
            <div class="row">
                <?php foreach ($alojamientos as $alojamiento): ?>
                    <?php if ($alojamiento['availability']): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card-body">
                                <img src="../assets/images/<?php echo $alojamiento['image']; ?>" class="card-img-top" alt="<?php echo $alojamiento['name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $alojamiento['name']; ?></h5>
                                    <p class="card-text"><?php echo $alojamiento['description']; ?></p>
                                    <p class="card-text">Ubicación: <?php echo $alojamiento['location']; ?></p>
                                    <p class="card-text">Precio: $<?php echo $alojamiento['price']; ?></p>
                                    <p class="card-text">Habitaciones: <?php echo $alojamiento['rooms']; ?></p>
                                    <p class="card-text">Disponibilidad: <?php echo $alojamiento['availability'] ? 'Disponible' : 'No disponible'; ?></p>
                                    <a href="accommodation_details.php?id=<?php echo $alojamiento['id']; ?>" class="btn btn-primary">Ver más</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <h2>Mis Reservas</h2>
            <ul>
                <?php foreach ($reservations as $reservation): ?>
                    <?php if ($reservation['user_id'] == $_SESSION['user_id']): ?>
                        <li>
                            <?php echo 'Alojamiento ID: ' . $reservation['alojamiento_id'] . ' - Check-in: ' . $reservation['checkin'] . ' - Check-out: ' . $reservation['checkout'] . ' - Total: $' . $reservation['total_amount']; ?>
                            <form action="../controllers/reservation_controller.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>
</html>