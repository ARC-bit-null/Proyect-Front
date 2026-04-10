<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ARC-bit-null Store</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="cyber-body">
    <div class="neon-form" style="text-align: center; max-width: 600px;">
        <h1>Acceso Concedido</h1>
        <hr>
        <p style="font-size: 1.2rem;">Bienvenido, <span style="text-shadow: 0 0 10px var(--neon-green);">Ingeniero <?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
        <p>Sistema central de la tienda.</p>
        <br>
        <a href="../logout.php" class="btn-neon" style="text-decoration: none; padding: 10px 20px; border: 1px solid var(--neon-green); display: inline-block;">Cerrar Sesión</a>
    </div>
</body>
</html>
