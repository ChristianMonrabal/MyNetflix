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
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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
