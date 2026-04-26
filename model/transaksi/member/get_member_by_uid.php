<?php
require_once __DIR__ . "/../../config/database.php";

$uid = mysqli_real_escape_string($conn, $_POST['uid']);

$query = "SELECT * FROM member_perpus WHERE uid = '$uid'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if ($data) {
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Member tidak ditemukan"
    ]);
}
