<?php
require_once __DIR__ . "/../../../config/database.php";

// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id            = mysqli_real_escape_string($conn, $_POST['id']);
    $name          = mysqli_real_escape_string($conn, $_POST['name']);
    $id_number     = mysqli_real_escape_string($conn, $_POST['id_number']);
    $username      = mysqli_real_escape_string($conn, $_POST['username']);
    $password      = mysqli_real_escape_string($conn, $_POST['password']); // Enkripsi password jika perlu
    $group_user_id = mysqli_real_escape_string($conn, $_POST['group_user_id']);
    $is_active     = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy     = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE users SET 
                name = '$name', 
                id_number = '$id_number', 
                username = '$username', 
                password = '$password', 
                group_user_id = '$group_user_id', 
                is_active = '$is_active', 
                updatedBy = '$updatedBy' 
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'User berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui user: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
