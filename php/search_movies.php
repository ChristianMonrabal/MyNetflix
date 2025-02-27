<?php
require_once '../includes/conexion.php';

$search = $_GET['search'] ?? '';
$director = $_GET['director'] ?? '';
$actor = $_GET['actor'] ?? '';
$genero = $_GET['genero'] ?? '';

$conditions = [];
$params = [];

if ($search) {
    $conditions[] = "(titulo LIKE :search OR description_pelicula LIKE :search)";
    $params[':search'] = "%" . $search . "%";
}

if ($director) {
    $conditions[] = "id_director = :director";
    $params[':director'] = $director;
}

if ($actor) {
    $conditions[] = "id_pelicula IN (SELECT id_pelicula FROM reparto WHERE id_actor = :actor)";
    $params[':actor'] = $actor;
}

if ($genero) {
    $conditions[] = "id_genero = :genero";
    $params[':genero'] = $genero;
}

$hayFiltros = !empty($search) || !empty($director) || !empty($actor) || !empty($genero);

if ($hayFiltros) {
    $sql = "SELECT * FROM peliculas WHERE " . implode(" AND ", $conditions);
    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<button id="clear-filters" class="btn btn-danger mb-3">Borrar filtros</button>';

    if ($result) {
        echo '<div class="row">';
        foreach ($result as $row) {
            echo '<div class="col-md-2 mb-3 div-img">';
            echo '<div class="card">';
            echo '<a href="show_movie.php?id=' . $row['id_pelicula'] . '">';
            echo '<img src="../img/carteleras/' . htmlspecialchars($row['imagen_cartelera']) . '" class="card-img-top" alt="Cartelera de ' . htmlspecialchars($row['titulo']) . '">';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No se encontraron resultados.</p>';
    }
} else {
}
?>
