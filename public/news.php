<?php
session_start();
require_once '../includes/conexion.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

// Obtener las películas ordenadas por fecha de estreno (más nuevas a más antiguas)
$sqlPeliculas = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, p.fecha_estreno
    FROM peliculas p
    ORDER BY p.fecha_estreno DESC;
";
$resultPeliculas = $pdo->query($sqlPeliculas);

$peliculas = $resultPeliculas->fetchAll(PDO::FETCH_ASSOC);

$peliculasLikeUsuario = [];
if (isset($_SESSION['email'])) {
    $sqlUsuario = "SELECT id_usuario FROM usuarios WHERE email = :email";
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->execute(['email' => $_SESSION['email']]);
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'];

    $sqlLikesUsuario = "
        SELECT p.id_pelicula, p.titulo, p.imagen_cartelera
        FROM peliculas p
        JOIN likes l ON p.id_pelicula = l.id_pelicula
        WHERE l.id_usuario = :id_usuario
        ORDER BY p.titulo;
    ";
    $stmtLikesUsuario = $pdo->prepare($sqlLikesUsuario);
    $stmtLikesUsuario->execute(['id_usuario' => $id_usuario]);
    $peliculasLikeUsuario = $stmtLikesUsuario->fetchAll(PDO::FETCH_ASSOC);
}

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
        <div class="container">
            <a class="navbar-brand" href="index.php">NetHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link" href="../index.php">Inicio</a>
                    <a class="nav-link" href="">Series</a>
                    <a class="nav-link" href="">Películas</a>
                    <a class="nav-link active" href="">Novedades</a>
                    <a class="nav-link" href="./mylist.php">Mi Lista</a>
                    <?php if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === true): ?>
                        <a class="nav-link" href="../admin/actived_users.php">Panel de administración</a>
                    <?php endif; ?>
                </div>
                <div class="navbar-nav ms-auto">
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
        <?php if (!empty($peliculas)): ?>
            <h3 class="mt-4">Novedades</h3>
            <div class="row">
                <?php foreach ($peliculas as $pelicula): ?>
                    <div class="col-md-2 mb-3">
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
