<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_member']) || empty($_POST['id_member'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

// Tangkap ID user yang akan dihapus dari AJAX
$id_member = mysqli_real_escape_string($conn, $_POST['id_member']);

// Query delete
$sql = "DELETE FROM member_perpus WHERE id_member = '$id_member'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Member berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus member: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
