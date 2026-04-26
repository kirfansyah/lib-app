<?php
require_once __DIR__ . '/../../config/database.php';

header("Content-Type: application/json");

// ambil 1 data terbaru yang belum dipakai
$result = mysqli_query($conn, "
    SELECT * FROM rfid_scans 
    WHERE status='new' AND type = 'member'
    ORDER BY id ASC 
    LIMIT 1
");

$data = mysqli_fetch_assoc($result);

if ($data) {
    // tandai sudah dipakai
    mysqli_query(
        $conn,
        "
        UPDATE rfid_scans 
        SET status='used' 
        WHERE id=" . $data['id']
    );

    echo json_encode($data);
} else {
    echo json_encode(null);
}
