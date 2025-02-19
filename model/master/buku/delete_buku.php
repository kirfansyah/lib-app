<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_buku']) || empty($_POST['id_buku'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

// Tangkap ID user yang akan dihapus dari AJAX
$id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);

// Query delete
$sql = "DELETE FROM master_buku WHERE id_buku = '$id_buku'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Buku berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus buku: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
