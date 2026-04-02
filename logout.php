<?php

session_start();
session_destroy(); // Borra la sesión en el servidor
header("Location: login.php"); // Te manda de vuelta al inicio
exit();
