<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();
// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id          = mysqli_real_escape_string($conn, $_POST['id_member']);
    $nama_member = mysqli_real_escape_string($conn, $_POST['nama_member']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp       = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat      = mysqli_real_escape_string($conn, $_POST['alamat']);
    $is_active   = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy   = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE member_perpus SET 
                nama_member = '$nama_member',
                email       = '$email',
                no_hp       = '$no_hp',
                alamat      = '$alamat',
                is_active   = '$is_active', 
                updateBy    = '$updatedBy' 
            WHERE id_member = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Member berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui member: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
