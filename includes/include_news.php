<?php
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);
} else {
    $email = null;
}

$sqlPeliculas = "
    SELECT p.id_pelicula, p.titulo, p.imagen_cartelera, p.fecha_estreno
    FROM peliculas p
    ORDER BY p.id_pelicula DESC;
";

$resultPeliculas = $pdo->query($sqlPeliculas);

$peliculas = $resultPeliculas->fetchAll(PDO::FETCH_ASSOC);

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
?>