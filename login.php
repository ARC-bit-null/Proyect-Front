<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: admin/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | ARC-bit-null Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="cyber-body">
    <div class="login-container">
        <form action="includes/auth_logic.php" method="POST" class="neon-form">
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
            <?php if (isset($_GET['error'])) : ?>
                <p style="color: #ff0000; margin-top: 10px;">Usuario o contraseña incorrectos.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
