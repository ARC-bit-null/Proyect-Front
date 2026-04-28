<?php

session_start();
require_once __DIR__ . '/../config/db.php';

session_destroy();
$redirectUrl = defined('BASE_URL') ? BASE_URL . '/login.php' : '/login.php';
header("Location: " . $redirectUrl);
exit();
