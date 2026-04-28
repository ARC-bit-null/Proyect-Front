<?php

session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../core/functions.php';
require_once __DIR__ . '/../../core/auth_middleware.php';

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
if (!empty($searchQuery)) {
    $productos = search_products($pdo, $searchQuery);
} else {
    $productos = get_all_products($pdo);
}

$productosConVentas = get_products_with_simulated_sales($pdo);
$categoriasVentas = get_categories_sales($pdo);
$kpis = get_dashboard_kpis();

$success = isset($_GET['success']) && $_GET['success'] == 1;
$deleted = isset($_GET['deleted']) && $_GET['deleted'] == 1;
$error = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ARC-bit-null</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/base.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/layout.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css">
</head>

<body class="admin-layout">
  <div class="app-container">
    <?php include __DIR__ . '/../../includes/admin/sidebar.php'; ?>

      <main class="main-content">
        <?php include __DIR__ . '/../../includes/admin/header.php'; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> Producto creado exitosamente.
        </div>
        <?php endif; ?>
        
        <?php if ($deleted): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> Producto eliminado exitosamente.
        </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
        <div class="alert alert-error">
            <i class="fa-solid fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($searchQuery): ?>
        <div class="search-results-view">
            <div class="search-header">
                <h2> Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
                <a href="<?php echo BASE_URL; ?>/admin/dashboard.php" class="btn-clear-search">
                    <i class="fa-solid fa-xmark"></i> Clear Search
                </a>
            </div>
            <div class="search-results-table">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo 'SKU-' . str_pad($producto['id'], 4, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['categoria_nombre'] ?? 'Uncategorized'); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                <td><?php echo number_format($producto['stock']); ?></td>
                                <td>
                                    <?php 
                                    $stock = intval($producto['stock']);
                                    $statusClass = '';
                                    $statusText = '';
                                    if ($stock > 15) {
                                        $statusClass = 'status-ok';
                                        $statusText = 'Good Stock';
                                    } elseif ($stock > 0) {
                                        $statusClass = 'status-low';
                                        $statusText = 'Low Stock';
                                    } else {
                                        $statusClass = 'status-out';
                                        $statusText = 'Out of Stock';
                                    }
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    No products found matching "<?php echo htmlspecialchars($searchQuery); ?>"
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        
        <div class="kpi-grid">
          <?php foreach ($kpis as $kpi) :?>
            <div class="kpi-card" style="
            --card-color: var(--neon-<?php echo $kpi['ui_theme']; ?>); 
            --card-glow: var(--neon-<?php echo $kpi['ui_theme']; ?>-glow);">
              
              <div class="kpi-header">
              <span class="kpi-title"><?php echo $kpi['title']; ?></span>
              </div>

              <div class="kpi-body">
                <span class="kpi-value"><?php echo $kpi['value_formatted']; ?></span>
              </div>

              <div class="kpi-chart-container" 
                   data-chart='<?php echo json_encode($kpi["chart_data"]); ?>' 
                   data-theme='<?php echo $kpi["ui_theme"]; ?>'></div>
            </div>
          <?php endforeach;?>
        </div>

        <div class="analytics-section">
            <div class="main-chart-container" style="
                --card-color: var(--neon-blue); 
                --card-glow: var(--neon-blue-glow);">
                <div class="chart-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>Detailed Orders & Revenue Time-series</h3>
                    <div class="chart-filter-menu" style="position: relative;">
                        <i class="fa-solid fa-ellipsis filter-toggle" style="cursor: pointer; color: var(--text-muted); font-size: 18px;"></i>
                        <div class="filter-dropdown">
                            <label><input type="checkbox" checked data-series="Revenue"> Revenue</label>
                            <label><input type="checkbox" checked data-series="New Orders"> New Orders</label>
                            <label><input type="checkbox" checked data-series="Order Value"> Order Value</label>
                        </div>
                    </div>
                </div>
                <div id="mainAnalyticsChart" 
                     data-neworders='<?php echo json_encode([120, 145, 168, 195, 220, 265, 298, 312, 345, 380, 412, 445]); ?>'
                     data-revenue='<?php echo json_encode([12500, 15800, 18200, 21500, 24800, 31200, 35600, 38900, 42100, 45600, 48900, 52385]); ?>'
                     data-ordervalue='<?php echo json_encode([280, 310, 340, 380, 420, 450, 490, 520, 560, 610, 650, 690]); ?>'></div>
            </div>
        </div>

        <div class="bottom-widgets">
            <div class="widget-category-sales" style="
                --card-color: var(--neon-pink); 
                --card-glow: var(--neon-pink-glow);">
                <h3>Category Sales</h3>
                <div id="categoryDonutChart" 
                     data-categories='<?php echo json_encode(array_column($categoriasVentas, 'category')); ?>'
                     data-sales='<?php echo json_encode(array_map(function($c) { return intval($c['simulated_sales']); }, $categoriasVentas)); ?>'></div>
            </div>

            <div class="widget-global-sales" style="
                --card-color: var(--neon-cyan); 
                --card-glow: var(--neon-cyan-glow);">
                <h3>Global Sales Heatmap</h3>
                <div id="globalSalesMap"></div>
            </div>

            <div class="widget-product-table" style="
                --card-color: var(--neon-purple); 
                --card-glow: var(--neon-purple-glow);">
                <h3>Product Performance & Inventory</h3>
                <div class="table-responsive">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Nombre</th>
                                <th>Ventas</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productosConVentas as $producto): ?>
                            <tr>
                                <td>
                                    <div class="product-icon-placeholder"></div>
                                    <span><?php echo 'SKU-' . str_pad($producto['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo number_format($producto['ventas_simuladas']); ?></td>
                                <td><?php echo number_format($producto['stock']); ?></td>
                                <td>
                                    <?php 
                                    $stock = intval($producto['stock']);
                                    $statusClass = '';
                                    $statusText = '';
                                    if ($stock > 15) {
                                        $statusClass = 'status-ok';
                                        $statusText = 'Good Stock';
                                    } elseif ($stock > 0) {
                                        $statusClass = 'status-low';
                                        $statusText = 'Low Stock';
                                    } else {
                                        $statusClass = 'status-out';
                                        $statusText = 'Out of Stock';
                                    }
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
      </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/dashboard.js"></script>
</body>
</html>