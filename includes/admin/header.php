<header class="main-header">
  <div class="header-container">
    <h1>ECOM-Command Center</h1>
    <div class="header-column-2">
      <form class="header-search" id="headerSearchForm" method="get" action="<?php echo defined('BASE_URL') ? BASE_URL . '/admin/dashboard.php' : '/admin/dashboard.php'; ?>">
        <input type="text" id="search" name="q" placeholder="Buscar por nombre, SKU o ID...">
        <ul class="search-filter">
          <li>Productos</li>
          <li>Pedidos</li>
          <li>Clientes</li>
        </ul>
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>

      <div class="header-actions">
        <div class="header-date" id="dateRangePicker">
          <i class="fa-regular fa-calendar"></i>
          <span class="date-text">Apr 01 - Apr 30, 2026</span>
          <i class="fa-solid fa-chevron-down"></i>
        </div>

        <div class="header-user">
          <div class="notification"><i class="fa-regular fa-bell"></i></div>
          <div class="user-profile" id="userProfile">
            <div class="profile-pic"></div>
            <span class="user-name">Eidikey</span>
            <span class="dropdown-icon"><i class="fa-solid fa-chevron-down"></i></span>
          </div>
          <div class="user-dropdown" id="userDropdown">
            <a href="<?php echo defined('BASE_URL') ? BASE_URL . '/profile.php' : '/profile.php'; ?>"><i class="fa-solid fa-user"></i> Mi Perfil</a>
            <a href="<?php echo defined('BASE_URL') ? BASE_URL . '/settings.php' : '/settings.php'; ?>"><i class="fa-solid fa-gear"></i> Configuración</a>
            <a href="<?php echo defined('BASE_URL') ? BASE_URL . '/logout.php' : '/logout.php'; ?>"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
(function() {
  // Search form - allow default submission for GET request
  const searchForm = document.getElementById('headerSearchForm');
  if (searchForm) {
    searchForm.addEventListener('submit', function(e) {
      const query = document.getElementById('search').value.trim();
      if (!query) {
        e.preventDefault();
        console.log('Empty search query');
      }
      // Allow form to submit normally with GET parameter ?q=
    });
  }

  // User profile dropdown toggle
  const userProfile = document.getElementById('userProfile');
  const userDropdown = document.getElementById('userDropdown');
  
  if (userProfile && userDropdown) {
    userProfile.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!userProfile.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove('show');
      }
    });
  }

  // Date range picker with Flatpickr
  const datePickerEl = document.getElementById('dateRangePicker');
  const dateText = datePickerEl ? datePickerEl.querySelector('.date-text') : null;

  if (datePickerEl && dateText) {
    const fp = flatpickr(datePickerEl, {
      mode: 'range',
      dateFormat: 'M d, Y',
      defaultDate: ['2026-04-01', '2026-04-30'],
      theme: 'dark',
      onChange: function(selectedDates) {
        if (selectedDates.length === 2) {
          const start = formatDate(selectedDates[0]);
          const end = formatDate(selectedDates[1]);
          dateText.textContent = start + ' - ' + end;
        }
      }
    });

    function formatDate(date) {
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      return months[date.getMonth()] + ' ' + 
             String(date.getDate()).padStart(2, '0') + ', ' + 
             date.getFullYear();
    }
  }
})();
</script>
