<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

// Tangkap ID user yang akan dihapus dari AJAX
$id = mysqli_real_escape_string($conn, $_POST['id']);

// Query delete
$sql = "DELETE FROM group_user WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Grup user berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus grup user: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
