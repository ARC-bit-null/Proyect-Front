<?php

// actions/process_product.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    // Validar CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Error de seguridad: Token CSRF no válido.");
    }

    // Sanitización y Captura de datos
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_DEFAULT));
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $stock  = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

    // Validación de tipos y negocio
    if (empty($nombre) || strlen($nombre) > 150) {
        $_SESSION['flash_error'] = "El nombre es obligatorio y debe tener máximo 150 caracteres.";
        header("Location: " . BASE_URL . "/admin/add_product.php");
        exit();
    }

    if ($precio === false || $precio < 0) {
        $_SESSION['flash_error'] = "El precio debe ser un número válido.";
        header("Location: " . BASE_URL . "/admin/add_product.php");
        exit();
    }

    if ($stock === false || $stock < 0) {
        $_SESSION['flash_error'] = "El stock debe ser un número entero válido.";
        header("Location: " . BASE_URL . "/admin/add_product.php");
        exit();
    }

    if (!$categoria_id) {
        $_SESSION['flash_error'] = "Debe seleccionar una categoría.";
        header("Location: " . BASE_URL . "/admin/add_product.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $categoria_id]);
        header("Location: " . BASE_URL . "/admin/dashboard.php?success=1");
        exit();
    } catch (PDOException $e) {
        error_log("Error al insertar producto: " . $e->getMessage());
        die("Error interno al procesar la solicitud.");
    }
} else {
    header("Location: " . BASE_URL . "/login.php");
    exit();
}
