<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();
// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id            = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $is_active     = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy     = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE master_kategori SET 
                nama_kategori = '$nama_kategori',
                is_active = '$is_active', 
                updateBy = '$updatedBy' 
            WHERE id_kategori= '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kategori: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
