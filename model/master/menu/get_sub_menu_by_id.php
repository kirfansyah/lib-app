<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "SELECT * FROM sub_menu WHERE id='$id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Grup user tidak ditemukan']);
}

$conn->close();
