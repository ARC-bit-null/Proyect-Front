<?php

session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../core/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$productos = get_all_products($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ARC-bit-null</title>
    <link rel="stylesheet" href="../assets/css/variables.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/layout.css">
    <link rel="stylesheet" href="../assets/css/components.css">
</head>
<body class="admin-layout">
        <?php include __DIR__ . '/../../includes/admin/header.php'; ?>
    <main class="main-content">
        </main>
</body>
</html>
