<?php
session_start();
$error = $_SESSION['error'] ?? '';
$email = $_SESSION['email'] ?? '';
unset($_SESSION['error'], $_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="../php/access.php" method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <p>Si no tienes cuenta, créala <a href="./signup.php">aquí</a></p>
</body>
</html>