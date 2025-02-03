<?php
    try {
        $sql = "SELECT id_usuario, email, fecha_registro FROM usuarios WHERE rol = 'disabled'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
?>