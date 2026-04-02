<?php

// 1. Requerimos la conexión a la base de datos
require_once 'db.php';

// 2. Iniciamos la sesión para poder "recordar" al usuario
session_start();

// 3. Verificamos que los datos vengan por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 4. Preparamos la consulta (Seguridad: Sentencia Preparada)
    // Buscamos al usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user]);
    $usuario = $stmt->fetch();

    // 5. Verificamos si el usuario existe y la contraseña coincide
    if ($usuario && password_verify($pass, $usuario['password'])) {
        // Guardamos datos importantes en la sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        // Redirigimos al dashboard o página principal
        header("Location: dashboard.php");
        exit();
    } else {
        // Si falló, regresamos al login con un mensaje de error
        echo "Usuario o contraseña incorrectos. <a href='login.php'>Volver</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | ARC-bit-null Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="cyber-body">
    <div class="login-container">
        <form action="auth.php" method="POST" class="neon-form">
            <h2>Acceso al Sistema</h2>
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-neon">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
