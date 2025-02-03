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
    <title>NetHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">

</head>

<body style="background-color: rgba(13, 27, 42, 1);">
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container-fluid">
            <a style="color: rgba(211, 211, 211, 1);" class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a style="color: rgba(211, 211, 211, 1);" class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a style="color: rgba(211, 211, 211, 1);" class="nav-link" href="#">Link</a>
                    </li>
                </ul>
                <form class="d-flex me-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button style="color: rgba(211, 211, 211, 1);" class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <div class="dropdown">
                    <button class="usuario-logueado dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i>
                        <?= htmlspecialchars($email) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="./logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <h1 id="titleIn" class="text-center text-white mt-5">Top 5 más gustadas</h1>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <?php if ($email): ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>Has iniciado sesión como: </p>
        <?php else: ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>No has iniciado sesión. <a href="./public/signin.php">Inicia sesión aquí</a>.</p>
        <?php endif; ?>
    </div>
</body>

</html>