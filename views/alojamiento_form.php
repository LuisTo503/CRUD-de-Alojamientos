<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar/Editar Alojamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Serif&family=Open+Sans&display=swap">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .form-title {
            font-family: 'Noto Serif', serif;
            color: #333;
        }
        .form-label {
            color: #555;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'partials/header.php'; ?>

    <main class="container mx-auto mt-10 p-5 bg-white shadow-md rounded">
        <h1 class="form-title text-2xl mb-5"><?php echo isset($alojamiento) ? 'Actualizar Alojamiento' : 'Crear Alojamiento'; ?></h1>
        <?php
        include_once '../config/database.php';
        include_once '../models/alojamiento_model.php';

        $database = new Database();
        $db = $database->getConnection();

        $alojamientoModel = new AlojamientoModel($db);
        $alojamiento = null;
        if (isset($_GET['id'])) {
            $alojamiento = $alojamientoModel->read($_GET['id']);
        }
        ?>
        <form action="../controllers/alojamiento_controller.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="name" class="form-label block mb-2">Nombre</label>
                <input type="text" class="form-control w-full p-2 border border-gray-300 rounded" id="name" name="name" value="<?php echo $alojamiento ? $alojamiento['name'] : ''; ?>" required>
            </div>
            <div>
                <label for="description" class="form-label block mb-2">Descripción</label>
                <textarea class="form-control w-full p-2 border border-gray-300 rounded" id="description" name="description" required><?php echo $alojamiento ? $alojamiento['description'] : ''; ?></textarea>
            </div>
            <div>
                <label for="location" class="form-label block mb-2">Ubicación</label>
                <input type="text" class="form-control w-full p-2 border border-gray-300 rounded" id="location" name="location" value="<?php echo $alojamiento ? $alojamiento['location'] : ''; ?>" required>
            </div>
            <div>
                <label for="price" class="form-label block mb-2">Precio</label>
                <input type="number" class="form-control w-full p-2 border border-gray-300 rounded" id="price" name="price" value="<?php echo $alojamiento ? $alojamiento['price'] : ''; ?>" required>
            </div>
            <div>
                <label for="rooms" class="form-label block mb-2">Habitaciones</label>
                <input type="number" class="form-control w-full p-2 border border-gray-300 rounded" id="rooms" name="rooms" value="<?php echo $alojamiento ? $alojamiento['rooms'] : ''; ?>" required>
            </div>
            <div>
                <label for="availability" class="form-label block mb-2">Disponibilidad</label>
                <select class="form-control w-full p-2 border border-gray-300 rounded" id="availability" name="availability" required>
                    <option value="1" <?php echo $alojamiento && $alojamiento['availability'] ? 'selected' : ''; ?>>Disponible</option>
                    <option value="0" <?php echo $alojamiento && !$alojamiento['availability'] ? 'selected' : ''; ?>>No disponible</option>
                </select>
            </div>
            <div>
                <label for="image" class="form-label block mb-2">Imagen</label>
                <input type="file" class="form-control w-full p-2 border border-gray-300 rounded" id="image" name="image">
                <?php if ($alojamiento && $alojamiento['image']): ?>
                    <img src="../assets/images/<?php echo $alojamiento['image']; ?>" alt="<?php echo $alojamiento['name']; ?>" class="mt-2 w-24 h-24 object-cover">
                <?php endif; ?>
            </div>
            <input type="hidden" name="id" value="<?php echo $alojamiento ? $alojamiento['id'] : ''; ?>">
            <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        </form>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>
</html>