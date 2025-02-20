<?php
session_start();
require_once '../includes/conexion.php';

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$email = strstr($email, '@', true);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_pelicula = $_GET['id'];

    $sql = "SELECT * FROM peliculas WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pelicula) {
        die("Película no encontrada.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/desktop/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">NetHub</a>
            <div class="navbar-nav mx-auto">
                <a class="nav-link" href="../admin/actived_users.php">Usuarios activos</a>
                <a class="nav-link" href="../admin/disabled_users.php">Usuarios deshabilitados</a>
                <a class="nav-link active" href="show_movies.php">Películas</a>
            </div>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-white"><?php echo htmlspecialchars($email); ?></span>
                <a href="../php/logout.php" class="nav-link text-white">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">Editar <?php echo htmlspecialchars($pelicula['titulo']); ?></h3>
                        <form action="../php/update_movies.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_pelicula" value="<?php echo htmlspecialchars($pelicula['id_pelicula']); ?>">
                            <input type="hidden" name="imagen_cartelera_actual" value="<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($pelicula['description_pelicula']); ?></textarea>
                                </div>
                            <div class="mb-3">
                                <label for="id_genero" class="form-label">Género</label>
                                <select class="form-select" id="id_genero" name="id_genero">
                                    <?php
                                    $sqlGeneros = "SELECT * FROM generos";
                                    $resultGeneros = $pdo->query($sqlGeneros);
                                    while ($row = $resultGeneros->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo $row['id_genero']; ?>" <?php echo $row['id_genero'] == $pelicula['id_genero'] ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_director" class="form-label">Director</label>
                                <select class="form-select" id="id_director" name="id_director">
                                    <?php
                                    $sqlDirectores = "SELECT * FROM directores";
                                    $resultDirectores = $pdo->query($sqlDirectores);
                                    while ($row = $resultDirectores->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo $row['id_director']; ?>" <?php echo $row['id_director'] == $pelicula['id_director'] ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_estreno" class="form-label">Fecha de Estreno</label>
                                <input type="date" class="form-control" id="fecha_estreno" name="fecha_estreno" value="<?php echo htmlspecialchars($pelicula['fecha_estreno']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="duracion" class="form-label">Duración (minutos)</label>
                                <input type="number" class="form-control" id="duracion" name="duracion" value="<?php echo htmlspecialchars($pelicula['duracion']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="imagen_cartelera" class="form-label">Imagen de Cartelera</label>
                                <input type="file" class="form-control" id="imagen_cartelera" name="imagen_cartelera" accept="image/*">
                                <input type="text" class="form-control mt-2" value="<?php echo htmlspecialchars($pelicula['imagen_cartelera']); ?>" readonly>
                            </div>
                            <?php
                                if (isset($_SESSION['error'])): ?>
                                    <div class="error">
                                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                                    </div>
                                    <?php unset($_SESSION['error']);
                                endif;
                            ?>
                            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validation_edit_movies.js"></script>
</body>
</html>