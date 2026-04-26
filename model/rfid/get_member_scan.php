<?php
require_once __DIR__ . "/../../config/database.php";

header('Content-Type: application/json');

// Ambil UID terakhir yg belum dipakai
$sql = "SELECT * FROM rfid_scans 
        WHERE status = 'new' AND type = 'member'
        ORDER BY id DESC 
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rfid = $result->fetch_assoc();

    $uid = $rfid['uid'];

    // Cari member berdasarkan UID
    $sqlMember = "SELECT * FROM member_perpus WHERE uid = '$uid' LIMIT 1";
    $resMember = $conn->query($sqlMember);

    // CEK ERROR QUERY
    if (!$resMember) {
        echo json_encode([
            "status" => "error",
            "message" => "Query member error: " . $conn->error
        ]);
        exit;
    }


    if ($resMember->num_rows > 0) {
        $member = $resMember->fetch_assoc();

        // update jadi sudah dipakai
        $conn->query("UPDATE rfid_scans SET status = 'used' WHERE id = " . $rfid['id']);

        echo json_encode([
            "status" => "success",
            "type"   => "member",
            "data"   => $member
        ]);
    } else {
        echo json_encode([
            "status" => "not_found",
            "message" => "Member tidak ditemukan",
            "uid" => $uid
        ]);
    }
} else {
    echo json_encode([
        "status" => "empty"
    ]);
}

$conn->close();
