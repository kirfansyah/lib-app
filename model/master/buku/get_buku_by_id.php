<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_buku']) || empty($_POST['id_buku'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);

$sql = "SELECT * FROM master_buku WHERE id_buku='$id_buku'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Buku tidak ditemukan']);
}

$conn->close();
