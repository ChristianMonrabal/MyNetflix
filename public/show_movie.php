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
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">NetHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link" href="../index.php">Inicio</a>
                    <a class="nav-link" href="">Series</a>
                    <a class="nav-link" href="">Películas</a>
                    <a class="nav-link" href="./news.php">Novedades</a>
                    <a class="nav-link" href="./mylist.php">Mi lista</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="search.php" class="btn btn-outline-light">
                        <i class="fas fa-search"></i>
                    </a>
                    <?php if ($email): ?>
                        <span class="nav-link text-white"><?php echo htmlspecialchars($email); ?></span>
                        <a href="../php/logout.php" class="nav-link text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    <?php else: ?>
                        <a href="public/signin.php" class="nav-link text-white">Iniciar sesión</a>
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
