<?php
session_start();
require_once '../includes/conexion.php';
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
    <link rel="stylesheet" href="../css/mobile/actived_users.css">
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
                    <a class="nav-link" href="../admin/actived_users.php">Usuarios activos</a>
                    <a class="nav-link" href="../admin/disabled_users.php">Usuarios deshabilitados</a>
                    <a class="nav-link active" href="#">Películas</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a class="btn btn-add-movie" href="../admin/new_movies.php">Añadir películas</a>
                </div>
                <div class="dropdown mx-4">
                    <button class="usuario-logueado dropdown-toggle mx-4" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-2"></i>
                        <?= htmlspecialchars($_SESSION['email'] ?? 'Invitado') ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
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
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Género</th>
                    <th>Director</th>
                    <th>Fecha de Estreno</th>
                    <th>Duración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="movies-table">
                <tr>
                    <td colspan="7" class="text-center">Cargando películas...</td>
                </tr>
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
