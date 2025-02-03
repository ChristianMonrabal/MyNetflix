<?php
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $email = strstr($email, '@', true);
} else {
    $email = null;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($email): ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>Has iniciado sesión como: <?php echo htmlspecialchars($email); ?></p>
            <a href="./php/logout.php" class="btn btn-danger">Cerrar sesión</a>
        <?php else: ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>No has iniciado sesión. <a href="./public/signin.php">Inicia sesión aquí</a>.</p>
        <?php endif; ?>
    </div>
</body>
</html>
