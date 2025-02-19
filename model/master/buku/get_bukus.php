<?php
require_once __DIR__ . "/../../../config/database.php";

$sql = "SELECT * FROM vwmstbuku WHERE is_active = 1 ORDER BY id_buku DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Ambil semua data
    }
    echo json_encode(['status' => 'success', 'data' => $data]); // Kirim semua data
} else {
    echo json_encode(['status' => 'error', 'message' => 'Kategori buku tidak ditemukan']);
}

$conn->close();
