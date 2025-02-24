<?php
session_start();
require_once '../includes/conexion.php';

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
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/desktop/index.css">
    <link rel="stylesheet" href="../css/desktop/search.css">
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
                <a class="nav-link active" href="../index.php">Inicio</a>
                <a class="nav-link" href="">Series</a>
                <a class="nav-link" href="">Películas</a>
                <a class="nav-link" href="news.php">Novedades</a>
                <a class="nav-link" href="mylist.php">Mi lista</a>
                <?php if (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === true): ?>
                    <a class="nav-link" href="../admin/actived_users.php">Panel de administración</a>
                <?php endif; ?>
            </div>
            <div class="navbar-nav ms-auto">
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

<div class="container mt-4">
    <form id="search-form">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar películas, series..." name="search" id="search">
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="director" class="form-label">Director</label>
                <select name="director" id="director" class="form-select">
                    <option value="">Seleccionar director</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM directores");
                    while ($directorOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $directorOption['id_director'] . '">' . htmlspecialchars($directorOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="actor" class="form-label">Actor</label>
                <select name="actor" id="actor" class="form-select">
                    <option value="">Seleccionar actor</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM actores");
                    while ($actorOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $actorOption['id_actor'] . '">' . htmlspecialchars($actorOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label">Género</label>
                <select name="genero" id="genero" class="form-select">
                    <option value="">Seleccionar género</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM generos");
                    while ($generoOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $generoOption['id_genero'] . '">' . htmlspecialchars($generoOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>
</div>

<div class="container mt-4" id="results"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/filter_movies.js"></script>
</body>
</html>
