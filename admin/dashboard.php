<?php
session_start();
require_once '../includes/db.php';

// Protección de sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// 1. Consulta para obtener productos con el nombre de su categoría
try {
    $query = "SELECT p.*, c.nombre as categoria_nombre 
              FROM productos p 
              LEFT JOIN categorias c ON p.categoria_id = c.id 
              ORDER BY p.fecha_creacion DESC";
    $stmt = $pdo->query($query);
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_db = "Error al cargar inventario: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control | ARC-bit-null</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: var(--neon-green);
            background: rgba(0, 0, 0, 0.5);
        }
        .inventory-table th, .inventory-table td {
            border: 1px solid var(--neon-green);
            padding: 10px;
            text-align: left;
        }
        .inventory-table th {
            background: rgba(0, 255, 0, 0.1);
            text-transform: uppercase;
        }
        .status-low { color: #ff0000; text-shadow: 0 0 5px #ff0000; }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="cyber-body">
    <div class="neon-form" style="max-width: 900px; width: 95%;">
        <div class="dashboard-header">
            <h1>SISTEMA DE INVENTARIO</h1>
            <a href="../logout.php" class="btn-logout" style="margin-top: 0;">Salir</a>
        </div>
        
        <p>Operador: <span class="user-highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
        <hr>

        <?php if (isset($error_db)) : ?>
            <p class="error-msg"><?php echo $error_db; ?></p>
        <?php else : ?>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p) : ?>
                    <tr>
                        <td>#<?php echo $p['id']; ?></td>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria_nombre'] ?? 'Sin categoría'); ?></td>
                        <td>$<?php echo number_format($p['precio'], 2); ?></td>
                        <td class="<?php echo ($p['stock'] < 5) ? 'status-low' : ''; ?>">
                            <?php echo $p['stock']; ?>
                        </td>
                        <td>
                            <?php echo ($p['stock'] > 0) ? 'EN LÍNEA' : 'AGOTADO'; ?>
                        </td>
                        <td>
                          <a href="../includes/delete_product.php?id=<?= $p['id'] ?>" 
                            onclick="return confirm('¿Confirmar destrucción de datos para el ID #<?= $p['id'] ?>?');"
                            style="color: #ff0000; text-decoration: none;">
                            <i class="fa-solid fa-trash"></i> ELIMINAR
                          </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

      <div style="margin-top: 20px; text-align: right;">
        <a href="add_product.php" class="btn-neon" style="text-decoration: none; display: inline-block; width: auto; padding: 10px 30px;">+ Añadir Producto</a>
      </div>
    </div>
</body>
</html>
