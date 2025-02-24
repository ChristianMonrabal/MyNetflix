<?php
if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] !== true) {
    header("Location: ../public/signin.php");
    exit();
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $email = strstr($email, '@', true);

    $sql_usuario = "SELECT id_usuario FROM usuarios WHERE email = :email";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->execute(['email' => $_SESSION['email']]);
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    $id_usuario = $usuario['id_usuario'];
} else {
    $id_usuario = null;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}

$id_pelicula = $_GET['id'];

$sql_check_like = "SELECT COUNT(*) FROM likes WHERE id_usuario = :id_usuario AND id_pelicula = :id_pelicula";
$stmt_check_like = $pdo->prepare($sql_check_like);
$stmt_check_like->execute(['id_usuario' => $id_usuario, 'id_pelicula' => $id_pelicula]);
$like_exists = $stmt_check_like->fetchColumn();

$sql_count_likes = "SELECT COUNT(*) as total_likes FROM likes WHERE id_pelicula = :id_pelicula";
$stmt_count_likes = $pdo->prepare($sql_count_likes);
$stmt_count_likes->execute(['id_pelicula' => $id_pelicula]);
$total_likes = $stmt_count_likes->fetchColumn();

$sql = "
    SELECT p.titulo, p.fecha_estreno, p.duracion, p.imagen_cartelera, p.description_pelicula, 
        g.nombre AS genero, d.nombre AS director
    FROM peliculas p
    JOIN generos g ON p.id_genero = g.id_genero
    JOIN directores d ON p.id_director = d.id_director
    WHERE p.id_pelicula = :id_pelicula
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_pelicula' => $id_pelicula]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelicula) {
    header("Location: ../index.php");
    exit;
}
?>