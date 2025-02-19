<?php
require_once __DIR__ . "/../../../config/database.php";

$sql = "SELECT * FROM group_user WHERE is_active = 1 AND id <> 1";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Ambil semua data
    }
    echo json_encode(['status' => 'success', 'data' => $data]); // Kirim semua data
} else {
    echo json_encode(['status' => 'error', 'message' => 'Grup user tidak ditemukan']);
}

$conn->close();
