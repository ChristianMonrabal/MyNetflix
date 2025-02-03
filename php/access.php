<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $_SESSION['email'] = $email;

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header("Location: ../public/signin.php");
        exit();
    }

    try {
        $sql = "SELECT id_usuario, pwd, rol FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['pwd'])) {
            if ($usuario['rol'] === 'cliente') {
                $_SESSION['LOGGEDIN'] = true;
                $_SESSION['USER_ID'] = $usuario['id_usuario'];
                header("Location: ../index.php");
                exit();
            } elseif ($usuario['rol'] === 'administrador') {
                $_SESSION['LOGGEDIN'] = true;
                $_SESSION['USER_ID'] = $usuario['id_usuario'];
                $_SESSION['ADMIN'] = true;
                header("Location: ../admin/actived_users.php");
                exit();
            } elseif ($usuario['rol'] === 'disabled') {
                $_SESSION['error'] = "Cuenta no activa";
                header("Location: ../public/signin.php");
                exit();
            }
        }

        $_SESSION['error'] = "Credenciales incorrectas";
        header("Location: ../public/signin.php");
        exit();
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: ../public/signin.php");
    exit();
}