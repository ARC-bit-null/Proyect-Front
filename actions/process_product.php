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
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS));
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $stock  = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

    // Validación básica de negocio
    if (!$nombre || $precio === false || $stock === false || !$categoria_id) {
        $_SESSION['flash_error'] = "Todos los campos son obligatorios y deben tener el formato correcto.";
        header("Location: admin/add_product.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $categoria_id]);
        // Redirección basada en la URL del navegador
        header("Location: admin/dashboard.php?success=1");
        exit();
    } catch (PDOException $e) {
        // En producción, logueamos el error y mostramos algo genérico
        error_log("Error al insertar producto: " . $e->getMessage());
        die("Error interno al procesar la solicitud.");
    }
} else {
    // Si intentan entrar por URL o no están logueados
    header("Location: ../login.php");
    exit();
}
