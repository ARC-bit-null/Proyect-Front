<?php

// actions/delete_product.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';

// Cambiamos a POST para mayor seguridad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    // Validar Token CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Error de seguridad: Acción no autorizada.");
    }

    // Validar y sanitizar el ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        $_SESSION['flash_error'] = "ID de producto no válido.";
        header("Location: " . BASE_URL . "/admin/dashboard.php?deleted=1");

        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: " . BASE_URL . "/admin/dashboard.php?deleted=1");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar producto ID $id: " . $e->getMessage());
        die("Error interno al procesar la eliminación.");
    }
} else {
    header("Location: " . BASE_URL . "/admin/dashboard.php");
    exit();
}
