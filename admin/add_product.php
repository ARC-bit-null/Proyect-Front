<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Producto | ARC-bit-null</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="cyber-body">
    <div class="neon-form" style="max-width: 500px;">
        <h2>Nuevo Producto</h2>
        <form action="../includes/process_product.php" method="POST">
            <div class="input-group">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="input-group">
                <label>Precio:</label>
                <input type="number" step="0.01" name="precio" required>
            </div>
            <div class="input-group">
                <label>Stock Inicial:</label>
                <input type="number" name="stock" required>
            </div>
            <div class="input-group">
                <label>Categoría:</label>
                <select name="categoria_id" style="width: 100%; background: transparent; border: 1px solid var(--neon-green); color: var(--neon-green); padding: 10px;">
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>" style="background: var(--dark-bg);"><?= htmlspecialchars($cat['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-neon">Guardar</button>
                <a href="dashboard.php" class="btn-logout" style="text-decoration:none; text-align:center; flex:1; margin-top:15px; line-height:30px;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
