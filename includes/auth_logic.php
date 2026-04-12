<?php

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validar CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Acceso denegado: Fallo de verificación CSRF.");
    }

    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($pass, $usuario['password'])) {
        // 2. Prevenir Session Fixation
        session_regenerate_id(true);
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['rol_id'] = $usuario['rol_id'];
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        // 3. Uso de Flash Message en lugar de GET
        $_SESSION['flash_error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../login.php");
        exit();
    }
}
