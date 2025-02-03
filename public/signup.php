<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>

    <form action="../php/add_users.php" method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <br>
        <button type="submit">Registrar</button>
    </form>
    <br>
    <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red;">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div style="color: green;">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <p>Si ya tienes cuenta, inicia sesión <a href="./signin.php">aquí</a></p>
</body>
</html>