<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_member']) || empty($_POST['id_member'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_member = mysqli_real_escape_string($conn, $_POST['id_member']);

$sql = "SELECT * FROM member_perpus WHERE id_member='$id_member'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Member tidak ditemukan']);
}

$conn->close();
