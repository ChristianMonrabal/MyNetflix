<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pelicula'])) {
    $id_pelicula = $_POST['id_pelicula'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $id_genero = $_POST['id_genero'];
    $id_director = $_POST['id_director'];
    $fecha_estreno = $_POST['fecha_estreno'];
    $duracion = $_POST['duracion'];
    $imagen_cartelera = $_FILES['imagen_cartelera'];

    if (empty($titulo) || empty($descripcion) || empty($id_genero) || empty($id_director) || empty($fecha_estreno) || empty($duracion)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
        exit;
    }

    $sql = "UPDATE peliculas 
            SET titulo = :titulo, description_pelicula = :descripcion, id_genero = :id_genero, 
                id_director = :id_director, fecha_estreno = :fecha_estreno, duracion = :duracion 
            WHERE id_pelicula = :id_pelicula";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id_genero', $id_genero);
    $stmt->bindParam(':id_director', $id_director);
    $stmt->bindParam(':fecha_estreno', $fecha_estreno);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':id_pelicula', $id_pelicula);

    if ($stmt->execute()) {
        if ($imagen_cartelera['size'] > 0) {
            $target_dir = "../img/carteleras/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $imageFileType = strtolower(pathinfo($imagen_cartelera["name"], PATHINFO_EXTENSION));
            $imagen_nombre = preg_replace('/[^A-Za-z0-9_\-]/', '_', $titulo) . '.' . $imageFileType;
            $target_file = $target_dir . $imagen_nombre;

            $check = getimagesize($imagen_cartelera["tmp_name"]);
            if ($check === false) {
                $_SESSION['error'] = "El archivo no es una imagen.";
                header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
                exit;
            }

            if (file_exists($target_file)) {
                unlink($target_file);
            }

            if ($imagen_cartelera["size"] > 5000000) {
                $_SESSION['error'] = "Lo siento, el archivo es demasiado grande.";
                header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
                exit;
            }

            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $allowed_formats)) {
                $_SESSION['error'] = "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
                header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
                exit;
            }

            if (!move_uploaded_file($imagen_cartelera["tmp_name"], $target_file)) {
                $_SESSION['error'] = "Lo siento, hubo un error al subir tu archivo.";
                header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
                exit;
            }

            $sql = "UPDATE peliculas SET imagen_cartelera = :imagen_cartelera WHERE id_pelicula = :id_pelicula";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':imagen_cartelera', $imagen_nombre);
            $stmt->bindParam(':id_pelicula', $id_pelicula);
            $stmt->execute();
        }

        header("Location: ../admin/show_movies.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al actualizar la película.";
        header("Location: ../admin/edit_movies.php?id=" . $id_pelicula);
        exit;
    }
}
?>
