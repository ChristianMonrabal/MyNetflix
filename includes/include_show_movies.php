<?php
    if (!isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
        header('Location: ../index.php');
        exit();
    }

    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $email = strstr($email, '@', true);

    $sqlPeliculas = "
        SELECT p.id_pelicula, p.titulo, p.fecha_estreno, p.duracion, p.imagen_cartelera, p.description_pelicula, 
            g.nombre AS genero, d.nombre AS director
            FROM peliculas p
            JOIN generos g ON p.id_genero = g.id_genero
            JOIN directores d ON p.id_director = d.id_director
    ";

    $resultPeliculas = $pdo->query($sqlPeliculas);
?>