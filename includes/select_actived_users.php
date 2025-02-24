<?php

    if (!isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
        header('Location: ../index.php');
        exit();
    }

    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $email = strstr($email, '@', true);

    try {
        $sql = "SELECT id_usuario, email, rol, fecha_registro FROM usuarios WHERE rol != 'disabled'";
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
}
?>