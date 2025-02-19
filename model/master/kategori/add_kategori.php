<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();
// Tangkap data dari AJAX
$nama_kategori = $_POST['nama_kategori'];
$is_active     = $_POST['is_active'];
$createdBy     = $_SESSION['username'] ?? 'SYSTEM';


// Query insert
$sql = "INSERT INTO master_kategori (nama_kategori, is_active, createdBy) 
        VALUES ('$nama_kategori','$is_active', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan kategory: ' . $conn->error]);
}

$conn->close();
