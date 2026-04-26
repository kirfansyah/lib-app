<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();

// tangkap data
$uid          = $_POST['uid'] ?? '';
$judul_buku   = $_POST['judul_buku'];
$penulis      = $_POST['penulis'];
$penerbit     = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$id_kategori  = $_POST['id_kategori'];
$stok         = $_POST['stok'];
$is_active    = $_POST['is_active'];
$createdBy    = $_SESSION['username'] ?? 'SYSTEM';

// 🔥 1. CEK UID SUDAH ADA ATAU BELUM
$check = mysqli_query($conn, "
    SELECT id_buku 
    FROM master_buku 
    WHERE uid = '$uid'
    LIMIT 1
");

if (mysqli_num_rows($check) > 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'UID sudah digunakan, buku tidak bisa ditambahkan'
    ]);
    exit;
}

// 🔥 2. INSERT DATA JIKA AMAN
$sql = "INSERT INTO master_buku 
        (uid, judul_buku, penulis, penerbit, tahun_terbit, id_kategori, stok, is_active, createdBy) 
        VALUES 
        ('$uid','$judul_buku','$penulis','$penerbit','$tahun_terbit','$id_kategori','$stok','$is_active','$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Buku berhasil ditambahkan'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Gagal menambahkan buku: ' . $conn->error
    ]);
}

$conn->close();
