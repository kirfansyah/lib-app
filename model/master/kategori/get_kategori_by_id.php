<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_kategori']) || empty($_POST['id_kategori'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

$sql = "SELECT * FROM master_kategori WHERE id_kategori='$id_kategori'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
}

$conn->close();
