# 💻 Project-Front

Una plataforma web diseñada para la gestión, almacenamiento y visualización de
datos mediante gráficas dinámicas.

## 🚀 Funcionalidades

- **Interfaz Responsiva:** Diseño adaptable (Mobile First) optimizado para diversas resoluciones.
- **Animaciones Fluídas:** Experiencia de usuario mejorada mediante transiciones y keyframes de CSS puro.
- **Visualización de Datos:** Renderizado de métricas y estadísticas.

## 🛠 Tecnologías

- **Frontend:** HTML5, CSS3 (Custom Variables).
- **Backend:** PHP (Lógica de servidor).
- **Scripting:** Bash / Python (Automatización y procesamiento).
- **Herramientas:** Neovim, Git.

## 📦 Instalación y Despliegue

### Pasos para ejecutar

1. Clona el repositorio:

   ```bash
   git clone [https://github.com/ARC-bit-null/Proyect-Front.git](https://github.com/ARC-bit-null/Proyect-Front.git)
   ```

---

## 👥 Colaboradores

- **Francisco Angel** - _Desarrollador Principal_
- **Alejandro Lopez** - _Desarrollador Principal_

---

### 📝 Observaciones técnicas

- **Automatización:** Uso de Bash/Python para tareas de ingeniería y procesamiento de datos.
- **Separación de capas:** Arquitectura limpia que separa la estructura (HTML),
  los estilos (CSS) y la lógica (PHP).

## 📂 Estructura del Proyecto

La arquitectura sigue una separación estricta entre la lógica de servidor y los activos públicos para mejorar la seguridad y el mantenimiento.

```text
Proyect-Front/
├── 📁 actions/             # Lógica de procesamiento (Backend)
│   ├── auth_logic.php      # Cerebro de autenticación y sesiones
│   ├── delete_product.php  # Procesamiento de bajas
│   └── process_product.php # Procesamiento de altas y cambios
├── 📁 config/              # Configuraciones globales
│   └── db.php              # Conexión PDO a MariaDB
├── 📁 core/                # Funciones núcleo del sistema
│   └── functions.php       # Consultas reutilizables (get_all_products, etc.)
├── 📁 includes/            # Componentes reutilizables de UI
│   └── 📁 admin/
│       └── header.php      # Barra de navegación con buscador y perfil
└── 📁 public/              # Directorio raíz del servidor web
    ├── 📁 admin/           # Vistas protegidas del panel
    │   ├── dashboard.php   # Panel principal de administración
    │   └── add_product.php # Formulario de gestión de inventario
    ├── 📁 assets/          # Recursos estáticos
    │   ├── 📁 css/         # Estilos (variables.css, base.css, layout.css)
    │   └── 📁 img/         # Identidad visual (logo-ecommerce.png)
    ├── auth_handler.php    # Puente (Bridge) hacia actions/auth_logic.php
    ├── login.php           # Interfaz de acceso con validación CSRF
    └── logout.php          # Finalización de sesión segura
```
