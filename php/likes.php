<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['USER_ID'])) {
    echo json_encode(['error' => 'No estás autenticado']);
    exit;
}

$id_usuario = $_SESSION['USER_ID'];
$id_pelicula = isset($_POST['id_pelicula']) ? $_POST['id_pelicula'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

if ($id_pelicula && $action) {
    if ($action == 'add') {
        $sql = "INSERT INTO likes (id_usuario, id_pelicula) VALUES (:id_usuario, :id_pelicula)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario, 'id_pelicula' => $id_pelicula]);
    } elseif ($action == 'remove') {
        $sql = "DELETE FROM likes WHERE id_usuario = :id_usuario AND id_pelicula = :id_pelicula";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario, 'id_pelicula' => $id_pelicula]);
    }

    $sql = "SELECT COUNT(*) FROM likes WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_pelicula' => $id_pelicula]);
    $total_likes = $stmt->fetchColumn();

    echo json_encode(['success' => true, 'total_likes' => $total_likes]);
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
exit;
