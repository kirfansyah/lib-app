<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_peminjaman']) || empty($_POST['id_peminjaman'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_peminjaman = mysqli_real_escape_string($conn, $_POST['id_peminjaman']);

$sql = "SELECT * FROM vwmstpeminjaman WHERE id_peminjaman='$id_peminjaman'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Member tidak ditemukan']);
}

$conn->close();
