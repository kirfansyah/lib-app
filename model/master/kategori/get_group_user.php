<?php
require_once __DIR__ . "/../../../config/database.php";

$sql = "SELECT * FROM group_user WHERE is_active = 1 ORDER BY id";
$result = $conn->query($sql);

$data_group_user = array();
while ($row = $result->fetch_assoc()) {
    $data_group_user[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
    );
}
