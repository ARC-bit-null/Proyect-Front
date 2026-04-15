<?php
  $current_page = basename($_SERVER['SCRIPT_NAME']);
?>

  <div class="sidebar">
  <div class="sidebar-header">
      <a href="/" class="logo">
        <img src="<?php echo BASE_URL; ?>/assets/img/logo_ecommerce_nobg.png" alt="Logo E-commerce" class="logo-img">
        <div class="logo-text">
          <span class="logo-title">E-commerce</span>
          <span class="sidebar-title">Dashboard</span>
        </div>
      </a>
  </div>
  <ul class="menu-list">
      <li><a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a></li>
      <li><a href="orders.php" class="<?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>"><i class="fa-solid fa-cart-shopping"></i> Pedidos</a></li>
      <li><a href="products.php" class="<?php echo ($current_page == 'products.php') ? 'active' : ''; ?>"><i class="fa-solid fa-box-open"></i> Productos</a></li>
      <li><a href="customers.php" class="<?php echo ($current_page == 'customers.php') ? 'active' : ''; ?>"><i class="fa-solid fa-users"></i> Clientes</a></li>
      <li><a href="analytics.php" class="<?php echo ($current_page == 'analytics.php') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-line"></i> Analiticas</a></li>
      <li><a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><i class="fa-solid fa-gear"></i> Ajustes</a></li>
  </ul>
</div>
