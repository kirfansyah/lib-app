<?php
require_once __DIR__ . "/../../config/database.php";

header('Content-Type: application/json');

$sql = "SELECT * FROM rfid_scans
WHERE status = 'new'
AND type = 'buku'
ORDER BY id DESC
LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rfid = $result->fetch_assoc();

    $uid = $rfid['uid'];

    // cari buku dari uid RFID
    $sqlBuku = "SELECT * FROM master_buku WHERE uid = '$uid' LIMIT 1";
    $resBuku = $conn->query($sqlBuku);

    if ($resBuku && $resBuku->num_rows > 0) {
        $buku = $resBuku->fetch_assoc();

        $conn->query("UPDATE rfid_scans SET status = 'used' WHERE id = " . $rfid['id']);

        echo json_encode([
            "status" => "success",
            "data" => $buku
        ]);
    } else {
        echo json_encode([
            "status" => "not_found",
            "message" => "Buku tidak ditemukan",
            "uid" => $uid
        ]);
    }
} else {
    echo json_encode([
        "status" => "empty"
    ]);
}

$conn->close();
