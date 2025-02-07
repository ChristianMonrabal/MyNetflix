<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/desktop/signup.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registrate en NetHub</h2>
            <form action="../php/add_users.php" method="POST">
                <div class="input-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="Introduce tu correo electrónico">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Introduce tu contraseña">
                </div>
                <button type="submit" class="btn-submit">Registrar</button>
            </form>
            <br>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php elseif (isset($_SESSION['success'])): ?>
                <div class="success">
                    <?php echo htmlspecialchars($_SESSION['success']); ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <p class="signup-link">Si ya tienes cuenta, inicia sesión <a id="here" href="./signin.php">aquí</a></p>
        </div>
    </div>
    <script src="../js/validation_signup.js"></script>
</body>
</html>
