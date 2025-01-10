<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <main>
        <h1>Iniciar Sesión</h1>
        <form action="../controllers/auth_controller.php" method="POST">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="hidden" name="action" value="login">
            <button type="submit">Iniciar Sesión</button>
        </form>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>
</html>