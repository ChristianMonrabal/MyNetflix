<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $id_genero = $_POST['id_genero'];
    $id_director = $_POST['id_director'];
    $fecha_estreno = $_POST['fecha_estreno'];
    $duracion = $_POST['duracion'];
    $description_pelicula = $_POST['descripcion'];
    $imagen_cartelera = $_FILES['imagen_cartelera'];

    if (empty($titulo) || empty($id_genero) || empty($id_director) || empty($fecha_estreno) || empty($duracion) || empty($description_pelicula)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    $fecha_actual = date('Y-m-d');
    if ($fecha_estreno > $fecha_actual) {
        $_SESSION['error'] = "La fecha de estreno no puede ser posterior a la fecha actual.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    $target_dir = "../img/carteleras/";
    $imageFileType = strtolower(pathinfo($imagen_cartelera["name"], PATHINFO_EXTENSION));

    $imagen_nombre = preg_replace('/[^A-Za-z0-9_\-]/', '_', $titulo) . '.' . $imageFileType;
    $target_file = $target_dir . $imagen_nombre;

    $check = getimagesize($imagen_cartelera["tmp_name"]);
    if ($check === false) {
        $_SESSION['error'] = "El archivo no es una imagen.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    if (file_exists($target_file)) {
        $_SESSION['error'] = "Lo siento, el archivo ya existe.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    if ($imagen_cartelera["size"] > 5000000) {
        $_SESSION['error'] = "Lo siento, el archivo es demasiado grande.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        $_SESSION['error'] = "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    if (!move_uploaded_file($imagen_cartelera["tmp_name"], $target_file)) {
        $_SESSION['error'] = "Lo siento, hubo un error al subir tu archivo.";
        header("Location: ../admin/new_movies.php");
        exit;
    }

    $sql = "INSERT INTO peliculas (titulo, id_genero, id_director, fecha_estreno, duracion, imagen_cartelera, description_pelicula) 
            VALUES (:titulo, :id_genero, :id_director, :fecha_estreno, :duracion, :imagen_cartelera, :description_pelicula)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':id_genero', $id_genero);
    $stmt->bindParam(':id_director', $id_director);
    $stmt->bindParam(':fecha_estreno', $fecha_estreno);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':imagen_cartelera', $imagen_nombre);
    $stmt->bindParam(':description_pelicula', $description_pelicula);

    if ($stmt->execute()) {
        header("Location: ../admin/show_movies.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al añadir la película.";
        header("Location: ../admin/new_movies.php");
        exit;
    }
}
?>
