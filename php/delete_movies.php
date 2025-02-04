<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_pelicula = $_GET['id'];

    try {
        $pdo->beginTransaction();

        $sqlLikes = "DELETE FROM likes WHERE id_pelicula = :id_pelicula";
        $stmtLikes = $pdo->prepare($sqlLikes);
        $stmtLikes->bindParam(':id_pelicula', $id_pelicula);
        $stmtLikes->execute();

        $sqlReparto = "DELETE FROM reparto WHERE id_pelicula = :id_pelicula";
        $stmtReparto = $pdo->prepare($sqlReparto);
        $stmtReparto->bindParam(':id_pelicula', $id_pelicula);
        $stmtReparto->execute();

        $sql = "SELECT imagen_cartelera FROM peliculas WHERE id_pelicula = :id_pelicula";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pelicula', $id_pelicula);
        $stmt->execute();
        $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pelicula) {
            $imagen_cartelera = $pelicula['imagen_cartelera'];

            $sql = "DELETE FROM peliculas WHERE id_pelicula = :id_pelicula";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_pelicula', $id_pelicula);

            if ($stmt->execute()) {
                if (file_exists($imagen_cartelera)) {
                    unlink($imagen_cartelera);
                }
                $pdo->commit();

                header("Location: ../admin/show_movies.php");
                exit;
            } else {
                $pdo->rollBack();
                echo "Error al eliminar la película.";
            }
        } else {
            echo "Película no encontrada.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>