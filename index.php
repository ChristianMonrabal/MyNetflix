<?php
session_start();
require_once './includes/conexion.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

// Obtener el Top 3 de películas con más likes
$sqlTop3 = "
    SELECT p.id_pelicula, p.titulo, p.fecha_estreno, p.duracion, g.nombre AS genero, COUNT(l.id_like) AS total_likes
    FROM peliculas p
    LEFT JOIN likes l ON p.id_pelicula = l.id_pelicula
    JOIN generos g ON p.id_genero = g.id_genero
    GROUP BY p.id_pelicula
    ORDER BY total_likes DESC
    LIMIT 3;
";
$resultTop3 = $pdo->query($sqlTop3);

// Obtener las películas organizadas por género
$sqlGeneros = "
    SELECT p.id_pelicula, p.titulo, p.fecha_estreno, p.duracion, g.nombre AS genero, COUNT(l.id_like) AS total_likes
    FROM peliculas p
    LEFT JOIN likes l ON p.id_pelicula = l.id_pelicula
    JOIN generos g ON p.id_genero = g.id_genero
    GROUP BY p.id_pelicula, g.id_genero
    ORDER BY g.nombre, p.titulo;
";
$resultGeneros = $pdo->query($sqlGeneros);

$peliculasPorGenero = [];
while ($row = $resultGeneros->fetch(PDO::FETCH_ASSOC)) {
    $peliculasPorGenero[$row['genero']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if ($email): ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>Has iniciado sesión como: <?php echo htmlspecialchars($email); ?></p>
            <a href="./php/logout.php" class="btn btn-danger">Cerrar sesión</a>
        <?php else: ?>
            <h1 class="mb-4">Bienvenido</h1>
            <p>No has iniciado sesión. <a href="./public/signin.php">Inicia sesión aquí</a>.</p>
        <?php endif; ?>

        <!-- Top 3 Películas Más Populares -->
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
                    </div>
                </div>
            <?php 
            $top++;
            endwhile; ?>
        </div>

        <!-- Películas organizadas por género -->
        <h2 class="mt-5">Películas por Género</h2>
        <?php foreach ($peliculasPorGenero as $genero => $peliculas): ?>
            <h3 class="mt-4"><?php echo $genero; ?></h3>
            <div class="row">
                <?php foreach ($peliculas as $pelicula): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $pelicula['titulo']; ?></h5>
                                <p class="card-text"><?php echo $pelicula['fecha_estreno']; ?></p>
                                <p class="card-text">Duración: <?php echo $pelicula['duracion']; ?> min</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>