<?php

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

$sqlTop5 = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, COUNT(l.id_like) AS total_likes
    FROM peliculas p
    LEFT JOIN likes l ON p.id_pelicula = l.id_pelicula
    GROUP BY p.id_pelicula
    ORDER BY total_likes DESC
    LIMIT 5;
";
$resultTop5 = $pdo->query($sqlTop5);

$sqlGeneros = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, g.nombre AS genero
    FROM peliculas p
    JOIN generos g ON p.id_genero = g.id_genero
    ORDER BY g.nombre, p.titulo;
";
$resultGeneros = $pdo->query($sqlGeneros);

$peliculasPorGenero = [];
while ($row = $resultGeneros->fetch(PDO::FETCH_ASSOC)) {
    $peliculasPorGenero[$row['genero']][] = $row;
}

$peliculasLikeUsuario = [];
if (isset($_SESSION['email'])) {
    $sqlUsuario = "SELECT id_usuario FROM usuarios WHERE email = :email";
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->execute(['email' => $_SESSION['email']]);
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'];

    $sqlLikesUsuario = "
        SELECT p.id_pelicula, p.titulo, p.imagen_cartelera
        FROM peliculas p
        JOIN likes l ON p.id_pelicula = l.id_pelicula
        WHERE l.id_usuario = :id_usuario
        ORDER BY p.titulo;
    ";
    $stmtLikesUsuario = $pdo->prepare($sqlLikesUsuario);
    $stmtLikesUsuario->execute(['id_usuario' => $id_usuario]);
    $peliculasLikeUsuario = $stmtLikesUsuario->fetchAll(PDO::FETCH_ASSOC);
}

$isTop5Empty = $resultTop5->rowCount() === 0;
?>