<?php
session_start();
require_once '../includes/conexion.php';

$emailSearch = isset($_GET['email']) ? '%' . $_GET['email'] . '%' : null;

try {
    if ($emailSearch) {
        $sql = "SELECT id_usuario, email, rol, fecha_registro FROM usuarios WHERE rol != 'disabled' AND email LIKE :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $emailSearch, PDO::PARAM_STR);
    } else {
        $sql = "SELECT id_usuario, email, rol, fecha_registro FROM usuarios WHERE rol != 'disabled'";
        $stmt = $pdo->query($sql);
    }

    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
