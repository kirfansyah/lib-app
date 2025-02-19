<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

// Tangkap ID user yang akan dihapus dari AJAX
$id = mysqli_real_escape_string($conn, $_POST['id']);

// Query delete
$sql = "DELETE FROM master_kategori WHERE id_kategori = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kategori: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
