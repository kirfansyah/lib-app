<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();
// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id          = mysqli_real_escape_string($conn, $_POST['id_peminjaman']);
    $tanggal_kembali = mysqli_real_escape_string($conn, date('Y-m-d', strtotime($_POST['tanggal_kembali'])));
    $denda       = mysqli_real_escape_string($conn, $_POST['denda']);
    $updatedBy   = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE transaksi_peminjaman SET 
                tanggal_kembali = '$tanggal_kembali',
                denda           = '$denda',
                status          = 'dikembalikan',
                updateBy        = '$updatedBy' 
            WHERE id_peminjaman = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'data berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
