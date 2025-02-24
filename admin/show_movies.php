<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/include_show_movies.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar películas</title>
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
                <a class="nav-link active" href="#">Películas</a>
            </div>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-add-movie" href="../admin/new_movies.php">Añadir películas</a>
                <span class="nav-link text-white"><?php echo htmlspecialchars($email); ?></span>
                <a href="../php/logout.php" class="nav-link text-white">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <h5>Buscar películas</h5>
    <div class="row mb-3">
        <div class="col-md-4 position-relative">
            <input type="text" id="search" class="form-control pe-5" placeholder="Buscar películas">
            <span id="clearSearch" class="position-absolute top-50 end-0 translate-middle-y pe-3 cursor-pointer" style="display:none;">
                <i class="fas fa-times"></i>
            </span>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-4 w-100">
        <thead class="table-dark">
        <tr>
            <th id="table-titulo">Título</th>
            <th id="table-descripcion">Descripción</th>
            <th id="table-genero">Género</th>
            <th id="table-director">Director</th>
            <th id="table-fecha-estreno">Fecha de Estreno</th>
            <th id="table-duracion">Duración</th>
            <th id="table-acciones">Acciones</th>
        </tr>
        </thead>
        <tbody id="movies-table">
            <?php while ($row = $resultPeliculas->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['description_pelicula'] ?? '', 0, 100) . '...'); ?></td>
                    <td><?php echo htmlspecialchars($row['genero']); ?></td>
                    <td><?php echo htmlspecialchars($row['director']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_estreno']); ?></td>
                    <td><?php echo htmlspecialchars($row['duracion']); ?> min</td>
                    <td style="white-space: nowrap;">
                        <a href="edit_movies.php?id=<?php echo $row['id_pelicula']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeleteMovie(<?php echo $row['id_pelicula']; ?>)">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/filter_movies_crud.js"></script>
    <script src="../js/sweet_alerts.js"></script>
</body>
</html>