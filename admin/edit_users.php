<?php
session_start();
require_once '../includes/conexion.php';
require_once '../includes/include_edit_users.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
                <a class="nav-link active" href="actived_users.php">Usuarios</a>
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
                        <h3 class="mb-4 text-center">Editar <?php echo htmlspecialchars($usuario['email']); ?></h3>
                        <form action="../php/update_users.php" method="post">
                            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pwd" name="pwd">
                            </div>
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol">
                                    <option value="cliente" <?php echo $usuario['rol'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                                    <option value="administrador" <?php echo $usuario['rol'] == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                                    <option value="disabled" <?php echo $usuario['rol'] == 'disabled' ? 'selected' : ''; ?>>Deshabilitado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                <input type="text" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($usuario['fecha_registro']); ?>" readonly>
                            </div>
                            <?php if (isset($_SESSION['error'])): ?>
                            <div>
                                <p style="color: red";><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                            </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/validation_edit_users.js"></script>
</body>
</html>
