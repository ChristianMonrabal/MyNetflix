<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/include_news.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/desktop/index.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container d-flex">
            <!-- Botón de hamburguesa a la izquierda -->
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Logo NetHub y botón de búsqueda -->
            <div class="d-flex align-items-center ms-auto">
                <a class="navbar-brand" href="../index.php">NetHub</a>
                <a href="../public/search.php" class="btn btn-outline-light ms-3">
                    <i class="fas fa-search"></i>
                </a>
            </div>

            <!-- Contenedor del menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link active" href="../index.php">Inicio</a>
                    <a class="nav-link" href="../public/news.php">Novedades</a>
                    <a class="nav-link" href="../public/mylist.php">Mi lista</a>
                    <?php if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === true): ?>
                        <a class="nav-link" href="../admin/actived_users.php">Panel de administración</a>
                    <?php endif; ?>
                </div>
                <div class="navbar-nav ms-auto">
                    <?php if ($email): ?>
                        <div class="dropdown mx-4">
                            <button class="usuario-logueado dropdown-toggle mx-4" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <?= htmlspecialchars($email) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="public/signin.php" class="usuario-logueado text-decoration-none mx-4">
                            <i class="fas fa-user me-2"></i>
                            Iniciar sesión
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <?php if (!empty($peliculas)): ?>
            <h3 class="mt-4">Novedades</h3>
            <div class="row">
                <?php foreach ($peliculas as $pelicula): ?>
                    <div class="col-md-2 mb-3 div-img">
                        <a href="./show_movie.php?id=<?php echo $pelicula['id_pelicula']; ?>" class="carteleras">
                            <img src="../img/carteleras/<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" class="img-fluid rounded-start" alt="Cartelera de <?php echo htmlspecialchars($pelicula['titulo']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>