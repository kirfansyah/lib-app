<?php
// require_once __DIR__ . '/../../config/database.php';

// header("Content-Type: application/json");

// $input = json_decode(file_get_contents("php://input"), true);
// $uid = $input['uid'] ?? null;

// if (!$uid) {
//     echo json_encode(["status" => false]);
//     exit;
// }

// // simpan ke buffer
// mysqli_query($conn, "
//     INSERT INTO rfid_scans(uid, status) 
//     VALUES ('$uid', 'new')
// ");

// echo json_encode(["status" => true]);


require_once __DIR__ . '/../../config/database.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$uid = $input['uid'] ?? null;

if (!$uid) {
    echo json_encode(["status" => false, "message" => "UID kosong"]);
    exit;
}

// default type
$type = 'member';

// cek huruf depan
if (strpos($uid, 'E2') === 0) {
    $type = 'buku';
}

// simpan ke buffer
$query = "
    INSERT INTO rfid_scans(uid, type, status)
    VALUES ('$uid', '$type', 'new')
";

$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode([
        "status" => true,
        "type" => $type,
        "uid" => $uid
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => mysqli_error($conn)
    ]);
}
