<?php
session_start();
require_once '../includes/conexion.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$director = isset($_GET['director']) ? $_GET['director'] : '';
$actor = isset($_GET['actor']) ? $_GET['actor'] : '';
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';

$filtrosActivos = !empty($search) || !empty($director) || !empty($actor) || !empty($genero);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
    <form action="search.php" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar películas, series..." name="search" value="<?php echo htmlspecialchars($search); ?>" aria-label="Buscar">
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="director" class="form-label">Director</label>
                <select name="director" class="form-select">
                    <option value="">Seleccionar director</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM directores");
                    while ($directorOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $directorOption['id_director'] . '" ' . ($director == $directorOption['id_director'] ? 'selected' : '') . '>' . htmlspecialchars($directorOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="actor" class="form-label">Actor</label>
                <select name="actor" class="form-select">
                    <option value="">Seleccionar actor</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM actores");
                    while ($actorOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $actorOption['id_actor'] . '" ' . ($actor == $actorOption['id_actor'] ? 'selected' : '') . '>' . htmlspecialchars($actorOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label">Género</label>
                <select name="genero" class="form-select">
                    <option value="">Seleccionar género</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM generos");
                    while ($generoOption = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $generoOption['id_genero'] . '" ' . ($genero == $generoOption['id_genero'] ? 'selected' : '') . '>' . htmlspecialchars($generoOption['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
            <?php if ($filtrosActivos): ?>
                <a href="search.php" class="btn btn-outline-danger">Borrar filtros</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php
if ($filtrosActivos) {
    $conditions = [];
    $params = [];

    if ($search) {
        $conditions[] = "(titulo LIKE :search OR description_pelicula LIKE :search)";
        $params[':search'] = "%" . $search . "%";
    }

    if ($director) {
        $conditions[] = "id_director = :director";
        $params[':director'] = $director;
    }

    if ($actor) {
        $conditions[] = "id_pelicula IN (SELECT id_pelicula FROM reparto WHERE id_actor = :actor)";
        $params[':actor'] = $actor;
    }

    if ($genero) {
        $conditions[] = "id_genero = :genero";
        $params[':genero'] = $genero;
    }

    $sql = "SELECT * FROM peliculas";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        ?>
        <div class="container mt-4">
            <h3>Resultados de la búsqueda</h3>
            <div class="row">
                <?php foreach ($result as $row): ?>
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card">
                            <a href="show_movie.php?id=<?php echo $row['id_pelicula']; ?>">
                                <img src="../img/carteleras/<?php echo htmlspecialchars($row['imagen_cartelera']); ?>" class="card-img-top" alt="Cartelera de <?php echo htmlspecialchars($row['titulo']); ?>">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="container mt-4">
            <p>No se encontraron resultados.</p>
        </div>
        <?php
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
