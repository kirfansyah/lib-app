<?php
require_once __DIR__ . "/database.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// print_r($_SESSION);
// die;


$baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/";

// Jika user sudah login (ada session), arahkan ke dashboard
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $baseUrl . 'login');
    exit();
}
