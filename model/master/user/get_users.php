<?php

require_once __DIR__ . "/../../../config/database.php";
$default = '0000-00-00 00:00:00';
$sql = "SELECT * FROM vwmstuser";
$result = $conn->query($sql);

$data = array();
$no = 1;
while ($row = $result->fetch_assoc()) {
    // Pisahkan setiap kolom ke dalam variabel agar lebih fleksibel
    $nomor      = $no++;
    $nama       = $row['name'];
    $nomor_id   = $row['id_number'];
    $username   = $row['username'];
    $password   = str_repeat('*', 8);
    $level_user = ucfirst($row['leveluser']);
    $create_by  = $row['createdBy']  . '<br>' . ($row['createdAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['createdAt'])));
    $update_by  = $row['updatedBy']  . '<br>' . ($row['updatedAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['updatedAt'])));
    $is_active   = $row['is_active'] == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Non-active</span>';
    $actions    = ' <a class="me-3 edit-data" href="#" id="edit-data" data-id="' . $row['id'] . '" data-bs-toggle="modal" data-bs-target="#create">
                    <img src="assets/img/icons/edit.svg" alt="img">
                    </a>
                    <a class="confirm-text delete-user" href="#" id="delete-user" data-id="' . $row['id'] . '">
                    <img src="assets/img/icons/delete.svg" alt="img">
                    </a>
                ';

    // Tambahkan ke array data
    $data[] = array(
        $nomor,
        $nama,
        $nomor_id,
        $username,
        $password,
        $level_user,
        $create_by,
        $update_by,
        $is_active,
        $actions,
    );
}

$response = array("data" => $data);

echo json_encode($response);
