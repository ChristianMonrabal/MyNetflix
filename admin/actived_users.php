<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/select_actived_users.php';

if (!isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
    header('Location: ../index.php');
    exit();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$email = strstr($email, '@', true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Activos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">NetHub</a>
    <div class="navbar-nav mx-auto">
            <a class="nav-link active" href="">Usuarios activos</a>
            <a class="nav-link" href="disabled_users.php">Usuarios deshabilitados</a>
        </div>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white"><?php echo htmlspecialchars($email); ?></span>
            <a href="../php/logout.php" class="nav-link text-white">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h5>Buscar usuarios</h5>
    <div class="row mb-3">
        <div class="col-md-4 position-relative">
            <input type="text" id="emailSearch" class="form-control pe-5" placeholder="Buscar por email...">
            <span id="clearSearch" class="position-absolute top-50 end-0 translate-middle-y pe-3 cursor-pointer" style="display:none;">
                <i class="fas fa-times"></i>
            </span>
        </div>
</div>

    
    <?php if (empty($usuarios)): ?>
        <div class="alert alert-info text-center">No hay usuarios activos en este momento.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Email</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="userTable">
            </tbody>
        </table>
    <?php endif; ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/filter_user_active.js"></script>
</body>
</html>
