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
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Usuario eliminado con éxito";
        } else {
            $_SESSION['error'] = "No se pudo eliminar el usuario";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "ID de usuario no válido";
}

header("Location: ../admin/disabled_users.php");
exit();
?>