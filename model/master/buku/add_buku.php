<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();
// Tangkap data dari AJAX
$judul_buku   = $_POST['judul_buku'];
$penulis      = $_POST['penulis'];
$penerbit     = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$id_kategori  = $_POST['id_kategori'];
$stok         = $_POST['stok'];
$is_active    = $_POST['is_active'];
$createdBy    = $_SESSION['username'] ?? 'SYSTEM';


// Query insert
$sql = "INSERT INTO master_buku (judul_buku,penulis,penerbit,tahun_terbit,id_kategori,stok, is_active, createdBy) 
        VALUES ('$judul_buku','$penulis','$penerbit','$tahun_terbit','$id_kategori','$stok','$is_active', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Buku berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan buku: ' . $conn->error]);
}

$conn->close();
