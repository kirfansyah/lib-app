<?php
require_once __DIR__ . "/../../../config/database.php";

// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id            = mysqli_real_escape_string($conn, $_POST['id']);
    $name          = mysqli_real_escape_string($conn, $_POST['name']);
    $is_active     = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy     = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE group_user SET 
                name = '$name',                 
                is_active = '$is_active', 
                updatedBy = '$updatedBy' 
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Grup user berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui grup user: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
