<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';


// Tangkap data dari AJAX
$name           = $_POST['name'];
$icon           = $_POST['icon'];
$url            = $_POST['url'];
$ordinal_number = $_POST['ordinal_number'];
$is_active      = $_POST['is_active'];
$createdBy     = $_SESSION['username'] ?? 'SYSTEM';


// Generate UUID v4
$uuid = generateUUIDv4();

// Query insert
$sql = "INSERT INTO menu (name, icon, url, ordinal_number, is_active, createdBy) 
        VALUES ('$name','$icon','$url','$ordinal_number','$is_active', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan grup user: ' . $conn->error]);
}

$conn->close();
