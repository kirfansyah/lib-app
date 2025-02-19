<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();
// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id           = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $judul_buku   = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $penulis      = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit     = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori  = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $stok         = mysqli_real_escape_string($conn, $_POST['stok']);
    $is_active    = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy    = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE master_buku SET 
                judul_buku   = '$judul_buku',
                penulis      = '$penulis',
                penerbit     = '$penerbit',
                tahun_terbit = '$tahun_terbit',
                id_kategori  = '$id_kategori',
                stok         = '$stok',
                is_active    = '$is_active', 
                updateBy     = '$updatedBy' 
            WHERE id_buku    = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Buku berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui buku: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
