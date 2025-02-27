<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/include_show_movie.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pelicula['titulo']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/desktop/show_movie.css">
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
        <a href="javascript:history.back()" class="btn btn-outline-light">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="row">
            <div class="col-12 text-center mb-3">
            </div>
            <div class="col-md-4">
                <img src="../img/carteleras/<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" class="img-fluid rounded" alt="Cartelera de <?php echo htmlspecialchars($pelicula['titulo']); ?>">
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($pelicula['titulo']); ?></h2>
                <p><strong>Descripción:</strong></p>
                <p><?php echo nl2br(htmlspecialchars($pelicula['description_pelicula'])); ?></p>
                <p><strong>Género:</strong> <?php echo htmlspecialchars($pelicula['genero']); ?></p>
                <p><strong>Director:</strong> <?php echo htmlspecialchars($pelicula['director']); ?></p>
                <p><strong>Fecha de estreno:</strong> <?php echo htmlspecialchars($pelicula['fecha_estreno']); ?></p>
                <p><strong>Duración:</strong> <?php echo htmlspecialchars($pelicula['duracion']); ?> min</p>

                <a href="https://www.youtube.com/results?search_query=<?php echo urlencode($pelicula['titulo'] . ' trailer'); ?>"
                    target="_blank"
                    class="btn btn-danger">
                    <i class="fab fa-youtube"></i> Ver tráiler
                </a>
                <br><br>

                <p><strong>Likes:</strong> <?php echo $total_likes; ?></p>

                <?php if ($id_usuario): ?>
                    <form action="../php/likes.php" method="POST">
                        <input type="hidden" name="id_pelicula" value="<?php echo $id_pelicula; ?>">
                        <?php if ($like_exists): ?>
                            <button type="submit" name="action" value="remove" class="btn btn-outline-light">
                                <i class="fas fa-thumbs-down"></i> No me gusta
                            </button>
                        <?php else: ?>
                            <button type="submit" name="action" value="add" class="btn btn-outline-light">
                                <i class="fas fa-thumbs-up"></i> Me gusta
                            </button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>