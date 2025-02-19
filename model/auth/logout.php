<?php
require_once __DIR__ . "/../../config/config.php";
session_start();
session_destroy(); // Hapus semua session
header("Location: " . $baseUrl); // Redirect ke halaman login
exit();
