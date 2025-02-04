<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de usuario inválido.";
    header("Location: ../admin/disabled_users.php");
    exit();
}

$id_usuario = $_GET['id'];

try {
    $sql = "UPDATE usuarios SET rol = 'cliente' WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Usuario activado correctamente.";
    } else {
        $_SESSION['error'] = "Error al activar el usuario.";
    }

    header("Location: ../admin/disabled_users.php");
    exit();
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
