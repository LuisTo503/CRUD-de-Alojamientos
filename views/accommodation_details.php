<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Alojamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=Open+Sans&display=swap">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .card-title {
            font-family: 'Noto Serif', serif;
            color: #333;
        }
        .card-text {
            color: #555;
        }
        .form-label {
            color: #555;
        }
        .section-separator {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <main class="container mt-5">
        <?php
        include_once '../config/database.php';
        include_once '../models/alojamiento_model.php';

        $database = new Database();
        $db = $database->getConnection();

        $alojamientoModel = new AlojamientoModel($db);
        $alojamiento = $alojamientoModel->read($_GET['id']);
        ?>

        <div class="card mb-4 section-separator">
            <img src="../assets/images/<?php echo $alojamiento['image']; ?>" class="card-img-top" alt="<?php echo $alojamiento['name']; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $alojamiento['name']; ?></h5>
                <p class="card-text"><?php echo $alojamiento['description']; ?></p>
                <p class="card-text">Ubicación: <?php echo $alojamiento['location']; ?></p>
                <p class="card-text">Precio por noche: $<?php echo $alojamiento['price']; ?></p>
                <p class="card-text">Habitaciones: <?php echo $alojamiento['rooms']; ?></p>
                <p class="card-text">Disponibilidad: <?php echo $alojamiento['availability'] ? 'Disponible' : 'No disponible'; ?></p>
            </div>
        </div>

        <?php if ($alojamiento['availability']): ?>
            <h2 class="section-separator">Reservar</h2>
            <form action="../controllers/reservation_controller.php" method="POST" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="checkin" class="form-label">Fecha de entrada:</label>
                        <input type="date" class="form-control" id="checkin" name="checkin" required>
                        <div class="invalid-feedback">
                            Por favor, seleccione la fecha de entrada.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="checkout" class="form-label">Fecha de salida:</label>
                        <input type="date" class="form-control" id="checkout" name="checkout" required>
                        <div class="invalid-feedback">
                            Por favor, seleccione la fecha de salida.
                        </div>
                    </div>
                </div>
                <input type="hidden" name="alojamiento_id" value="<?php echo $alojamiento['id']; ?>">
                <input type="hidden" name="price" value="<?php echo $alojamiento['price']; ?>">
                <input type="hidden" name="action" value="create">
                <div class="row g-3 mt-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Reservar</button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <p class="section-separator">Este alojamiento no está disponible.</p>
        <?php endif; ?>

        <button onclick="window.location.href='dashboard.php'" class="btn btn-secondary mt-3">Volver al Dashboard</button>
    </main>

    <?php include 'partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>