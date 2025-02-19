<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_peminjaman']) || empty($_POST['id_peminjaman'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

// Tangkap ID user yang akan dihapus dari AJAX
$id_peminjaman = mysqli_real_escape_string($conn, $_POST['id_peminjaman']);

// Query delete
$sql = "DELETE FROM transaksi_peminjaman WHERE id_peminjaman = '$id_peminjaman'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Member berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus member: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
