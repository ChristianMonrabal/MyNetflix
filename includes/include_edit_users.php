<?php
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $email = strstr($email, '@', true);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id_usuario = $_GET['id'];

        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            die("Usuario no encontrado.");
        }
    }
?>