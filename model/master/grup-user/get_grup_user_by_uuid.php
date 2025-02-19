<?php
require_once __DIR__ . "/../../../config/database.php";
// require_once __DIR__ . "/../../../config/config.php";

if (!isset($_GET['params'][0]) || empty($_GET['params'][0])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim !']);
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['params'][0]);

$sql = "SELECT * FROM group_user WHERE uuid='$id'";

$result = $conn->query($sql);

$data_group_user = array();
while ($row = $result->fetch_assoc()) {
    $data_group_user[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
    );
}

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     echo json_encode(['status' => 'success', 'data' => $row]);
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Grup user tidak ditemukan']);
// }

// $conn->close();
