<?php

// actions/auth_logic.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        error_log("Fallo de CSRF en login detectado.");
        die("Acceso denegado.");
    }

    $user = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $pass = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$user]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($pass, $usuario['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['rol_id'] = $usuario['rol_id'];

            header("Location: admin/dashboard.php");
            exit();
        } else {
            $_SESSION['flash_error'] = "Credenciales inválidas.";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error en autenticación: " . $e->getMessage());
        die("Error interno en el servidor.");
    }
}
