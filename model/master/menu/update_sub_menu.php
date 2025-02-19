<?php
require_once __DIR__ . "/../../../config/database.php";

// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari AJAX
    $id             = mysqli_real_escape_string($conn, $_POST['id_sub_menu']);
    $name           = mysqli_real_escape_string($conn, $_POST['name']);
    $menu_id        = mysqli_real_escape_string($conn, $_POST['menu_id']);
    $icon           = mysqli_real_escape_string($conn, $_POST['icon']);
    $url            = mysqli_real_escape_string($conn, $_POST['url']);
    $ordinal_number = mysqli_real_escape_string($conn, $_POST['ordinal_number']);
    $is_active      = mysqli_real_escape_string($conn, $_POST['is_active']);
    $updateBy       = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // Query update
    $sql = "UPDATE sub_menu SET 
                name           = '$name',                 
                icon           = '$icon',                 
                menu_id        = '$menu_id',                 
                url            = '$url',                 
                ordinal_number = '$ordinal_number',                 
                is_active      = '$is_active', 
                updateBy       = '$updateBy' 
            WHERE id           = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Sub menu berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui sub menu: ' . $conn->error]);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
}
