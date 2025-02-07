<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['USER_ID'])) {
    header("Location: ../public/signin.php");
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
}

header("Location: ../public/show_movie.php?id=" . $id_pelicula);
exit;
?>
