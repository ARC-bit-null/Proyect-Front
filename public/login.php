<?php
session_start();

// Si ya está logueado, redirigir al dashboard
// Asumimos que la carpeta 'admin' está dentro de 'public'
if (isset($_SESSION['username'])) {
    header("Location: admin/dashboard.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ARC-bit-null Store</title>
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="cyber-body">
    <div class="login-container">
        <form action="auth_handler.php" method="POST" class="neon-form">
            <h2>Acceso al Sistema</h2>
            
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-neon">Iniciar Sesión</button>
            
            <?php
            if (isset($_SESSION['flash_error'])) {
                echo '<p class="error-msg">' . htmlspecialchars($_SESSION['flash_error']) . '</p>';
                unset($_SESSION['flash_error']);
            }
            ?>
        </form>
    </div>
</body>
</html>
