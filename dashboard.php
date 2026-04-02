<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Tienda Arco</title>
</head>
<body style="background: #0d0d0d; color: #00ff00; font-family: monospace;">
    <h1>Acceso Concedido, Ingeniero <?php echo $_SESSION['username']; ?></h1>
    <p>Has entrado al sistema central de la tienda.</p>
    <a href="logout.php" style="color: red;">Cerrar Sesión</a>
</body>
</html>
