<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Alojamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <main>
        <h1>Crear Nuevo Alojamiento</h1>
        <form action="../controllers/alojamiento_controller.php" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="location">Ubicación:</label>
            <input type="text" id="location" name="location" required>
            
            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" required>
            
            <label for="user_id">ID de Usuario:</label>
            <input type="number" id="user_id" name="user_id" required>
            
            <input type="hidden" name="action" value="create">
            <button type="submit">Crear</button>
        </form>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>
</html>