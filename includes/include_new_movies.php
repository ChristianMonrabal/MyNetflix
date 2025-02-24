<?php
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $email = strstr($email, '@', true);

    $sqlGeneros = "SELECT id_genero, nombre FROM generos";
    $resultGeneros = $pdo->query($sqlGeneros);

    $sqlDirectores = "SELECT id_director, nombre FROM directores";
    $resultDirectores = $pdo->query($sqlDirectores);
?>