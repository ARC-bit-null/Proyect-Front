<?php

session_start();
require_once 'db.php';

// Verificación de seguridad básica
if (isset($_GET['id']) && isset($_SESSION['username'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ../admin/dashboard.php?deleted=1");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar el producto: " . $e->getMessage());
    }
} else {
    header("Location: ../admin/dashboard.php");
    exit();
}
