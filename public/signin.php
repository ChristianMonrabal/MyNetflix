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
    <link rel="stylesheet" href="../css/desktop/signin.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Inicia sesión en NetHub</h2>
            <form action="../php/access.php" method="POST">
                <div class="input-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="Introduce tu correo electrónico" value="<?php echo htmlspecialchars($email);?>">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Introduce tu contraseña">
                </div>
                    <?php if (!empty($error)): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                <button type="submit" class="btn-submit">Iniciar sesión</button>
            </form>
            <p class="signup-link">Si no tienes cuenta, créala <a id="here" href="./signup.php">aquí</a></p>
        </div>
    </div>
    <script src="../js/validation_signin.js"></script>
</body>
</html>
