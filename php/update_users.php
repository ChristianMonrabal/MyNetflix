<?php
session_start();
require_once '../includes/conexion.php';

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $rol = $_POST['rol'];

    if (empty($email)) {
        $_SESSION['error'] = 'El correo electrónico no puede estar vacío.';
        header('Location: ../admin/edit_users.php?id=' . $id_usuario);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'El correo electrónico no es válido.';
        header('Location: ../admin/edit_users.php?id=' . $id_usuario);
        exit();
    }

    if (!empty($password) && strlen($password) < 8) {
        $_SESSION['error'] = 'La contraseña debe tener al menos 8 caracteres.';
        header('Location: ../admin/edit_users.php?id=' . $id_usuario);
        exit();
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET email = :email, pwd = :pwd, rol = :rol WHERE id_usuario = :id_usuario";
    } else {
        $sql = "UPDATE usuarios SET email = :email, rol = :rol WHERE id_usuario = :id_usuario";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':id_usuario', $id_usuario);

    if (!empty($password)) {
        $stmt->bindParam(':pwd', $hashed_password);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Usuario actualizado correctamente.';
        header('Location: ../admin/actived_users.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error al actualizar el usuario.';
        header('Location: ../admin/edit_users.php?id=' . $id_usuario);
        exit();
    }
} else {
    $_SESSION['error'] = 'Solicitud inválida.';
    header('Location: ../admin/actived_users.php');
    exit();
}
