<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "inventario_sistema";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
