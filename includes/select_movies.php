<?php
require_once '../includes/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sqlPeliculas = "
    SELECT p.id_pelicula, p.titulo, p.fecha_estreno, p.duracion, p.imagen_cartelera, p.description_pelicula, 
        g.nombre AS genero, d.nombre AS director
        FROM peliculas p
        JOIN generos g ON p.id_genero = g.id_genero
        JOIN directores d ON p.id_director = d.id_director
        WHERE p.titulo LIKE :search";

$stmt = $pdo->prepare($sqlPeliculas);
$stmt->bindValue(':search', '%' . $search . '%');
$stmt->execute();
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($peliculas);
?>