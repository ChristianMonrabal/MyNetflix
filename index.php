<?php
session_start();
require_once './includes/conexion.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

$sqlTop5 = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, COUNT(l.id_like) AS total_likes
    FROM peliculas p
    LEFT JOIN likes l ON p.id_pelicula = l.id_pelicula
    GROUP BY p.id_pelicula
    ORDER BY total_likes DESC
    LIMIT 5;
";
$resultTop5 = $pdo->query($sqlTop5);

$sqlGeneros = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, g.nombre AS genero
    FROM peliculas p
    JOIN generos g ON p.id_genero = g.id_genero
    ORDER BY g.nombre, p.titulo;
";
$resultGeneros = $pdo->query($sqlGeneros);

$peliculasPorGenero = [];
while ($row = $resultGeneros->fetch(PDO::FETCH_ASSOC)) {
    $peliculasPorGenero[$row['genero']][] = $row;
}

$isTop5Empty = $resultTop5->rowCount() === 0;
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
                    <a class="nav-link" href="series.php">Series</a>
                    <a class="nav-link" href="peliculas.php">Películas</a>
                    <a class="nav-link" href="novedades.php">Novedades</a>
                    <a class="nav-link" href="mi_lista.php">Mi Lista</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <?php if ($email): ?>
                        <span class="nav-link text-white"><?php echo htmlspecialchars($email); ?></span>
                        <a href="php/logout.php" class="nav-link text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    <?php else: ?>
                        <a href="public/signin.php" class="nav-link text-white">Iniciar sesión</a>
                    <?php endif; ?>
    <title>NetHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css//desktop/index.css">
</head>

<body style="background-color: rgba(13, 27, 42, 1);">
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container-fluid">
            <a style="color: rgba(211, 211, 211, 1);" class="navbar-brand" href="#">NetHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                        <li><a class="dropdown-item" href="./php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
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

                <div class="row d-flex justify-content-center">
                    <?php foreach ($peliculas as $row): ?>
                        <div class="col-md-2 mb-4 text-center">
                            <p class="mt-2 text-white"><?php echo htmlspecialchars($row['total_likes']); ?> likes</p>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <h1 id="titleIn" class="text-center text-white mt-5">Top 5 más gustadas</h1>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <?php if (!$email): ?>

            <h1 class="mb-4">Bienvenido</h1>
            <p>No has iniciado sesión. <a href="./public/signin.php">Inicia sesión aquí</a>.</p>
        <?php endif; ?>

        <h2 class="mt-5">Top 3 Películas Más Populares</h2>
        <div class="row mt-3">
            <?php
            $top = 1;
            while ($row = $resultTop3->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                            <p class="card-text"><?php echo $row['genero']; ?> - <?php echo $row['fecha_estreno']; ?></p>
                            <p class="card-text">Duración: <?php echo $row['duracion']; ?> min</p>
                            <p class="text-muted">👍 <?php echo $row['total_likes']; ?> Me gusta</p>
                            <div class="display-1 text-primary">
                                <?php echo $top; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php
                $top++;
            endwhile; ?>
        </div>
        <?php foreach ($peliculasPorGenero as $genero => $peliculas): ?>
            <h3 class="mt-4"><?php echo htmlspecialchars($genero); ?></h3>
            <div class="row">
                <?php foreach ($peliculas as $pelicula): ?>
                    <div class="col-md-2 mb-3">
                        <a href="./public/show_movie.php?id=<?php echo $pelicula['id_pelicula']; ?>" class="carteleras">
                            <img src="./img/carteleras/<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" class="img-fluid rounded-start" alt="Cartelera de <?php echo htmlspecialchars($pelicula['titulo']); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
=======
</body>
</html>