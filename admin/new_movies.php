<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/include_new_movies.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/desktop/admin.css">
    <link rel="stylesheet" href="../css/desktop/index.css">
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
                    <a class="nav-link active" href="../admin/actived_users.php">Usuarios activos</a>
                    <a class="nav-link" href="../admin/disabled_users.php">Usuarios deshabilitados</a>
                    <a class="nav-link" href="../admin/show_movies.php">Películas</a>
                </div>
                <div class="dropdown mx-4">
                    <button class="usuario-logueado dropdown-toggle mx-4" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i>
                        <?= htmlspecialchars($email) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">Añadir película</h3>
                        <form action="../php/add_movies.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="id_genero" class="form-label">Género</label>
                                <select class="form-select" id="id_genero" name="id_genero" disabled>
                                    <option value="" selected disabled>Seleccione un género</option>
                                    <?php while ($row = $resultGeneros->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo $row['id_genero']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_director" class="form-label">Director</label>
                                <select class="form-select" id="id_director" name="id_director" disabled>
                                    <option value="" selected disabled>Seleccione un director</option>
                                    <?php while ($row = $resultDirectores->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo $row['id_director']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_estreno" class="form-label">Fecha de Estreno</label>
                                <input type="date" class="form-control" id="fecha_estreno" name="fecha_estreno">
                            </div>
                            <div class="mb-3">
                                <label for="duracion" class="form-label">Duración (minutos)</label>
                                <input type="number" class="form-control" id="duracion" name="duracion">
                            </div>
                            <div class="mb-3">
                                <label for="imagen_cartelera" class="form-label">Imagen de Cartelera</label>
                                <input type="file" class="form-control" id="imagen_cartelera" name="imagen_cartelera" accept="image/*">
                            </div>
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="error">
                                    <?php echo $_SESSION['error']; ?>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary w-100">Añadir Película</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validation_new_movies.js"></script>
</body>

</html>