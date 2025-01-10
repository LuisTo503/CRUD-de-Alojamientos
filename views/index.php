<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Alojamientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <main>
        <!-- Hero Slider -->
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../assets/images/image1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../assets/images/image2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../assets/images/image3.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../assets/images/image4.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="../assets/images/image5.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Accommodations Section -->
        <section class="container mt-5">
            <h2>Alojamientos</h2>
            <div class="row">
                <?php
                include_once '../config/database.php';
                include_once '../models/alojamiento_model.php';

                $database = new Database();
                $db = $database->getConnection();

                $alojamientoModel = new AlojamientoModel($db);
                $alojamientos = $alojamientoModel->readAll();

                foreach ($alojamientos as $alojamiento): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card-body">
                        <img src="../assets/images/<?php echo $alojamiento['image']; ?>" class="card-img-top" alt="<?php echo $alojamiento['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $alojamiento['name']; ?></h5>
                                <p class="card-text"><?php echo $alojamiento['description']; ?></p>
                                <p class="card-text">Ubicación: <?php echo $alojamiento['location']; ?></p>
                                <p class="card-text">Precio: $<?php echo $alojamiento['price']; ?></p>
                                <p class="card-text">Disponibilidad: <?php echo $alojamiento['availability'] ? 'Disponible' : 'No disponible'; ?></p>
                                <a href="accommodation_details.php?id=<?php echo $alojamiento['id']; ?>" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="container mt-5">
            <h2>Testimonios</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../assets/images/avatars/cipro-50x.jpg" class="card-img-top" alt="50px">
                        <div class="card-body">
                            <h5 class="card-title">Nombre del Usuario</h5>
                            <p class="card-text">Este es un testimonio corto.</p>
                            <p class="card-text">Puntuación: ★★★★☆</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../assets/images/avatars/jake-50x.jpg" class="card-img-top" alt="50px">
                        <div class="card-body">
                            <h5 class="card-title">Nombre del Usuario</h5>
                            <p class="card-text">Este es un testimonio corto.</p>
                            <p class="card-text">Puntuación: ★★★★★</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../assets/images/avatars/janny-50x.jpg" class="card-img-top" alt="50px">
                        <div class="card-body">
                            <h5 class="card-title">Nombre del Usuario</h5>
                            <p class="card-text">Este es un testimonio corto.</p>
                            <p class="card-text">Puntuación: ★★★☆☆</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>