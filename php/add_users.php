<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = '';

    if (empty($email) || empty($password)) {
        $error = 'Por favor, complete todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif (strlen($password) < 8) {
        $error = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if (!$error) {
        try {
            $sql = "SELECT email FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['error'] = 'El correo electrónico ya está registrado.';
                header('Location: ../public/signup.php');
                exit();
            }

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (email, pwd) VALUES (:email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['success'] = 'Cuenta creada correctamente. Está a la espera de ser aceptada.';
            } else {
                $_SESSION['error'] = 'Hubo un error al crear la cuenta. Por favor, inténtelo de nuevo más tarde.';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error en la base de datos: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = $error;
    }

    header('Location: ../public/signup.php');
    exit();
}
?>
