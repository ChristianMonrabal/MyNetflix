<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
    header('Location: ../index.php');
    exit();
}

$emailSearch = isset($_GET['email']) ? $_GET['email'] : '';

try {
    if ($emailSearch) {
        $sql = "SELECT id_usuario, email, fecha_registro FROM usuarios WHERE rol = 'disabled' AND email LIKE :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => '%' . $emailSearch . '%']);
    } else {
        $sql = "SELECT id_usuario, email, fecha_registro FROM usuarios WHERE rol = 'disabled'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($usuarios);
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>
