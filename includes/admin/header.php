<header class="main-header">
  <div class="header-container">
    <a href="/" class="logo">
    <img src="../public/assets/img/logo-ecommerce.jpg" alt="Logo E-commerce" class="logo-img">
      <div class="logo-text">
        <span class="logo-title">E-commerce</span>
      </div>
    </a>

    <form class="header-search" method="get" action="/">
        <select name="category" class="search-select">
        <option value="all">Todos</option>
        <option value="products">Productos</option>
        <option value="orders">Pedidos</option>
        <option value="clients">Clientes</option>
      </select>
      <input type="text" id="search" name="q" placeholder="Buscar por nombre, SKU o ID...">
      <button type="submit" class="search-btn">Buscar</button>
    </form>

    <div class="header-user">
      <div class="notification">Notis</div>
      <div class="user-profile">
        <div class="profile-pic"></div>
      </div>
    </div>
  </div>
</header>
