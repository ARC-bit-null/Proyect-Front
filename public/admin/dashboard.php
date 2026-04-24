<?php

session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../core/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$productos = get_all_products($pdo);
$kpis = get_dashboard_kpis();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ARC-bit-null</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/variables.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/base.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/layout.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="admin-layout">
  <div class="app-container">
    <?php include __DIR__ . '/../../includes/admin/sidebar.php'; ?>

      <main class="main-content">
        <?php include __DIR__ . '/../../includes/admin/header.php'; ?>
        <div class="kpi-grid">
          <?php foreach ($kpis as $kpi) :?>
            <div class="kpi-card" style="
            --card-color: var(--neon-<?php echo $kpi['ui_theme']; ?>); 
            --card-glow: var(--neon-<?php echo $kpi['ui_theme']; ?>-glow);">
              
              <div class="kpi-header">
              <span class="kpi-title"><?php echo $kpi['title']; ?></span>
              <i class="fa-solid fa-ellipsis"></i>
              </div>

              <div class="kpi-body">
                <span class="kpi-value"><?php echo $kpi['value_formatted']; ?></span>
              </div>

              <div class="kpi-chart-container" data-chart='<?php echo json_encode($kpi["chart_data"]); ?>'></div>
            </div>
          <?php endforeach;?>
        </div>
      </main>
  </div>
</body>
</html>
