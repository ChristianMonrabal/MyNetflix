<?php
require_once '../includes/conexion.php';

if (isset($_GET['id_pelicula'])) {
    $id_pelicula = intval($_GET['id_pelicula']);

    $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_pelicula', $id_pelicula, PDO::PARAM_INT);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'total_likes' => $fila['total_likes']]);
} else {
    echo json_encode(['success' => false]);
}
?>