<?php

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Consulta segura
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user]);
    $usuario = $stmt->fetch();

    if (password_verify($pass, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=1"); // Redirigir con aviso de error
        exit();
    }
    die();
}
