<?php
session_start();

require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['username'])) {
    header("Location: " . BASE_URL . "/admin/dashboard.php");
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
    <style>
        body.cyber-body {
            background-color: #0A0A0E;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .neon-form {
            background: rgba(26, 26, 34, 0.8);
            border: 1px solid var(--neon-cyan);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.2), 0 0 40px rgba(0, 255, 204, 0.1);
        }
        .neon-form h2 {
            color: var(--neon-cyan);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-size: 14px;
        }
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(10, 10, 14, 0.8);
            border: 1px solid var(--border-glass);
            border-radius: 6px;
            color: var(--text-main);
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 10px rgba(0, 255, 204, 0.3);
        }
        .btn-neon {
            width: 100%;
            padding: 14px;
            background: var(--neon-cyan);
            border: none;
            border-radius: 6px;
            color: #0A0A0E;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-neon:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.5);
        }
        .error-msg {
            color: #FF1744;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
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
