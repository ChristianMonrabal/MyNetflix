<?php
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $email = strstr($email, '@', true);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id_pelicula = $_GET['id'];

        $sql = "SELECT * FROM peliculas WHERE id_pelicula = :id_pelicula";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pelicula', $id_pelicula);
        $stmt->execute();
        $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pelicula) {
            die("Película no encontrada.");
        }
    }
?>