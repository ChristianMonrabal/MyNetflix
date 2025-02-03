<?php
session_start();
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $error = '';
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor, complete todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    }

    if ($error) {
        $_SESSION['error'] = $error;
        header('Location: ../public/signup.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO usuarios (email, pwd) VALUES (:email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Cuenta creada correctamente. Está a la espera de ser aceptada.';
        } else {
            $_SESSION['error'] = 'Hubo un error al crear la cuenta. Por favor, intente de nuevo.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error en la base de datos: ' . $e->getMessage();
    }

    header('Location: ../public/signup.php');
    exit();
}
?>