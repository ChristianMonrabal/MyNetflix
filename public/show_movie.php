<?php
session_start();
require_once '../includes/conexion.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);

    $sql_usuario = "SELECT id_usuario FROM usuarios WHERE email = :email";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->execute(['email' => $_SESSION['email']]);
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'];
} else {
    $id_usuario = null;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}

$id_pelicula = $_GET['id'];

$sql_check_like = "SELECT COUNT(*) FROM likes WHERE id_usuario = :id_usuario AND id_pelicula = :id_pelicula";
$stmt_check_like = $pdo->prepare($sql_check_like);
$stmt_check_like->execute(['id_usuario' => $id_usuario, 'id_pelicula' => $id_pelicula]);
$like_exists = $stmt_check_like->fetchColumn();

$sql = "
    SELECT p.titulo, p.fecha_estreno, p.duracion, p.imagen_cartelera, p.description_pelicula, 
        g.nombre AS genero, d.nombre AS director
    FROM peliculas p
    JOIN generos g ON p.id_genero = g.id_genero
    JOIN directores d ON p.id_director = d.id_director
    WHERE p.id_pelicula = :id_pelicula
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_pelicula' => $id_pelicula]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelicula) {
    header("Location: ../index.php");
    exit;
}
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
                    <a class="nav-link" href="../series.php">Series</a>
                    <a class="nav-link" href="../peliculas.php">Películas</a>
                    <a class="nav-link" href="../novedades.php">Novedades</a>
                    <a class="nav-link" href="../mi_lista.php">Mi Lista</a>
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
        <a href="../index.php" class="btn btn-outline-light">
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

                <?php if ($id_usuario): ?>
                    <form action="../php/likes.php" method="POST">
                        <input type="hidden" name="id_pelicula" value="<?php echo $id_pelicula; ?>">
                        <?php if ($like_exists): ?>
                            <button type="submit" name="action" value="remove" class="btn btn-outline-light">
                                <i class="fas fa-thumbs-down"></i> Quitar like
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
