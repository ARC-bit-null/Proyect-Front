<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../core/functions.php';
require_once __DIR__ . '/../../core/auth_middleware.php';

$categorias = get_all_categories($pdo);

// Generar token CSRF para este formulario
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto | ARC-bit-null</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/components.css">
</head>
<body class="admin-layout">
    <div class="container-form">
        <h2>Nuevo Producto</h2>
        <form action="product_handler.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="input-group">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required placeholder="Ej. Teclado Mecánico">
            </div>
            
            <div class="input-group">
                <label>Categoría:</label>
                <select name="categoria_id" class="custom-select">
                    <?php foreach ($categorias as $cat) : ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Guardar</button>
                <a href="dashboard.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
