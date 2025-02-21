<?php
session_start();
require_once './includes/conexion.php';
require_once './includes/select_index.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/desktop/index.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">NetHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link active" href="index.php">Inicio</a>
                    <a class="nav-link" href="">Series</a>
                    <a class="nav-link" href="">Películas</a>
                    <a class="nav-link" href="./public/news.php">Novedades</a>
                    <a class="nav-link" href="./public/mylist.php">Mi lista</a>
                    <?php if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === true): ?>
                        <a class="nav-link" href="./admin/actived_users.php">Panel de administración</a>
                    <?php endif; ?>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="./public/search.php" class="btn btn-outline-light">
                        <i class="fas fa-search"></i>
                    </a>
                    <?php if ($email): ?>
                        <span class="nav-link text-white ms-3"><?php echo htmlspecialchars($email); ?></span>
                        <a href="php/logout.php" class="nav-link text-white">
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
        <h2 class="mt-5 text-center">Las 5 películas más populares en España</h2>
        <br>
        <?php if ($isTop5Empty): ?>
            <p class="text-center">No hay likes en ninguna película.</p>
        <?php else: ?>
            <div class="row d-flex justify-content-center">
                <?php 
                    $peliculas = [];
                    while ($row = $resultTop5->fetch(PDO::FETCH_ASSOC)): 
                        $peliculas[] = $row;
                    endwhile;
                    
                    foreach ($peliculas as $row): ?>
                        <div class="col-md-2 mb-4 text-center">
                            <a href="./public/show_movie.php?id=<?php echo $row['id_pelicula']; ?>" class="carteleras">
                                <img src="./img/carteleras/<?php echo htmlspecialchars($row['imagen_cartelera']); ?>" class="img-fluid rounded" alt="Cartelera de <?php echo htmlspecialchars($row['titulo']); ?>">
                            </a>
                        </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($peliculasPorGenero as $genero => $peliculas): ?>
            <h3 class="mt-4"><?php echo htmlspecialchars($genero); ?></h3>
            
            <?php if (count($peliculas) > 6): ?>
                    <div id="carousel-<?php echo md5($genero); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach (array_chunk($peliculas, 6) as $index => $grupoPeliculas): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row">
                                        <?php foreach ($grupoPeliculas as $pelicula): ?>
                                            <div class="col-md-2 mb-3">
                                                <a href="./public/show_movie.php?id=<?php echo $pelicula['id_pelicula']; ?>" class="carteleras">
                                                    <img src="./img/carteleras/<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" class="img-fluid rounded" alt="Cartelera de <?php echo htmlspecialchars($pelicula['titulo']); ?>">
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo md5($genero); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo md5($genero); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($peliculas as $pelicula): ?>
                            <div class="col-md-2 mb-3">
                                <a href="./public/show_movie.php?id=<?php echo $pelicula['id_pelicula']; ?>" class="carteleras">
                                    <img src="./img/carteleras/<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" class="img-fluid rounded" alt="Cartelera de <?php echo htmlspecialchars($pelicula['titulo']); ?>">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>