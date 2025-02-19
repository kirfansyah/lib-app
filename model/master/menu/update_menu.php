<?php
require_once __DIR__ . "/../../../config/database.php";

// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id             = mysqli_real_escape_string($conn, $_POST['id']);
    $name           = mysqli_real_escape_string($conn, $_POST['name']);
    $icon           = mysqli_real_escape_string($conn, $_POST['icon']);
    $url            = mysqli_real_escape_string($conn, $_POST['url']);
    $ordinal_number = mysqli_real_escape_string($conn, $_POST['ordinal_number']);
    $is_active      = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updatedBy      = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE menu SET 
                name           = '$name',                 
                icon           = '$icon',                 
                url            = '$url',                 
                ordinal_number = '$ordinal_number',                 
                is_active      = '$is_active', 
                updatedBy      = '$updatedBy' 
            WHERE id           = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Menu berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui menu: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
