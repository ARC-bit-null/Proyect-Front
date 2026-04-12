<?php

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $nombre = trim($_POST['nombre']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $categoria_id]);
        header("Location: ../admin/dashboard.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Error al guardar el producto: " . $e->getMessage());
    }
} else {
    header("Location: ../admin/dashboard.php");
    exit();
}
