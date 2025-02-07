<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['LOGGEDIN']) || !isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
    $_SESSION['error'] = "Acceso no autorizado";
    header("Location: ../public/signin.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        $pdo->beginTransaction();

        $sql_likes = "DELETE FROM likes WHERE id_usuario = :id_usuario";
        $stmt_likes = $pdo->prepare($sql_likes);
        $stmt_likes->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        $stmt_likes->execute();

        $query_rol = "SELECT rol FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt_rol = $pdo->prepare($query_rol);
        $stmt_rol->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        $stmt_rol->execute();
        $usuario = $stmt_rol->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $_SESSION['error'] = "Usuario no encontrado";
            header("Location: ../admin/disabled_users.php");
            exit();
        }

        $rol_usuario = $usuario['rol'];

        $sql_user = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        $stmt_user->execute();

        $pdo->commit();

        $_SESSION['success'] = "Usuario eliminado con éxito";

        if ($rol_usuario === 'cliente') {
            header("Location: ../admin/actived_users.php");
        } else {
            header("Location: ../admin/disabled_users.php");
        }
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "ID de usuario no válido";
}

header("Location: ../admin/disabled_users.php");
exit();
?>
