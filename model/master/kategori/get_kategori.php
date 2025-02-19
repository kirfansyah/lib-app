<?php

require_once __DIR__ . "/../../../config/database.php";
$default = '0000-00-00 00:00:00';
$sql = "SELECT * FROM master_kategori";
$result = $conn->query($sql);

$data = array();
$no = 1;
while ($row = $result->fetch_assoc()) {
    // Pisahkan setiap kolom ke dalam variabel agar lebih fleksibel
    $nomor      = $no++;
    $nama       = $row['nama_kategori'];
    $create_by  = $row['createdBy']  . '<br>' . ($row['createdAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['createdAt'])));
    $update_by  = $row['updateBy']  . '<br>' . ($row['updateAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['updateAt'])));
    $is_active   = $row['is_active'] == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Non-active</span>';
    $actions    = ' <a class="me-3 edit-data" href="#" id="edit-data" data-id="' . $row['id_kategori'] . '" data-bs-toggle="modal" data-bs-target="#create">
                    <img src="assets/img/icons/edit.svg" alt="img">
                    </a>
                    <a class="confirm-text delete-data" href="#" id="delete-data" data-id="' . $row['id_kategori'] . '">
                    <img src="assets/img/icons/delete.svg" alt="img">
                    </a>
                ';

    // Tambahkan ke array data
    $data[] = array(
        $nomor,
        $nama,
        $create_by,
        $update_by,
        $is_active,
        $actions,
    );
}

$response = array("data" => $data);

echo json_encode($response);
