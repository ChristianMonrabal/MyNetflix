<?php
if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] !== true) {
    header("Location: ../public/signin.php");
    exit();
}

$email = $_SESSION['email'] ?? null;
$email = $email ? strstr($email, '@', true) : null;

$id_usuario = null;
if ($email) {
    $sqlUsuario = "SELECT id_usuario FROM usuarios WHERE email = :email";
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->execute(['email' => $_SESSION['email']]);
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'] ?? null;
}

$mostrarLikes = isset($_GET['like']) ? $_GET['like'] === 'true' : true;

if ($id_usuario) {
    if ($mostrarLikes) {
        $sqlPeliculas = "
            SELECT p.id_pelicula, p.titulo, p.imagen_cartelera
            FROM peliculas p
            JOIN likes l ON p.id_pelicula = l.id_pelicula
            WHERE l.id_usuario = :id_usuario
            ORDER BY p.titulo;
        ";
    } else {
        $sqlPeliculas = "
            SELECT p.id_pelicula, p.titulo, p.imagen_cartelera
            FROM peliculas p
            WHERE p.id_pelicula NOT IN (
                SELECT l.id_pelicula FROM likes l WHERE l.id_usuario = :id_usuario
            )
            ORDER BY p.titulo;
        ";
    }

    $stmtPeliculas = $pdo->prepare($sqlPeliculas);
    $stmtPeliculas->execute(['id_usuario' => $id_usuario]);
    $peliculas = $stmtPeliculas->fetchAll(PDO::FETCH_ASSOC);
}
?>