<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: admin/dashboard.php");
    exit();
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
            // Consumir el Flash Message
            if (isset($_SESSION['flash_error'])) {
                echo '<p class="error-msg">' . htmlspecialchars($_SESSION['flash_error']) . '</p>';
                unset($_SESSION['flash_error']); // Destruir tras imprimir
            }
            ?>
        </form>
    </div>
</body>
</html>
