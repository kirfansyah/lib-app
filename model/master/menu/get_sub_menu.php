<?php

// require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . "/../../../config/config.php";
$default = '0000-00-00 00:00:00';
$sql = "SELECT * FROM vwmstsubmenu";
$result = $conn->query($sql);

$data = array();
$no = 1;
while ($row = $result->fetch_assoc()) {
    // Pisahkan setiap kolom ke dalam variabel agar lebih fleksibel
    $nomor      = $no++;
    $nama       = $row['name'];
    $menu_name  = $row['menu_name'];
    $icon       = $row['icon'];
    $url        = $row['url'];
    $ordinal_number     = $row['ordinal_number'];
    $is_active  = $row['is_active'] == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Non-active</span>';
    $create_by  = $row['createdBy']  . '<br>' . ($row['createdAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['createdAt'])));
    $update_by  = $row['updateBy']  . '<br>' . ($row['updateAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['updateAt'])));
    $actions    = ' <a class="me-3 edit-sub-menu" href="#" id="edit-data" data-id="' . $row['id'] . '" data-bs-toggle="modal" data-bs-target="#create-sub-menu">
                    <img src="assets/img/icons/edit.svg" alt="img">
                    </a>
                    <a class="confirm-text delete-sub-menu" href="#" id="delete-sub-menu" data-id="' . $row['id'] . '">
                    <img src="assets/img/icons/delete.svg" alt="img">
                    </a>
                ';

    // Tambahkan ke array data
    $data[] = array(
        $nomor,
        $nama,
        $menu_name,
        $icon,
        $url,
        $ordinal_number,
        $is_active,
        $create_by,
        $update_by,
        $actions,
    );
}

$response = array("data" => $data);

echo json_encode($response);
