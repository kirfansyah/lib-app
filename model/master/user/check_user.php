<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['username']) || empty($_POST['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$username = mysqli_real_escape_string($conn, $_POST['username']);

$sql = "SELECT * FROM vwmstuser WHERE username='$username'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
}

$conn->close();
