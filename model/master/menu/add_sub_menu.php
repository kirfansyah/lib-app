<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';


// Tangkap data dari AJAX
$name           = $_POST['name'];
$menu_id        = $_POST['menu_id'];
$icon           = $_POST['icon'];
$url            = $_POST['url'];
$ordinal_number = $_POST['ordinal_number'];
$is_active      = $_POST['is_active'];
$createdBy     = $_SESSION['username'] ?? 'SYSTEM';




// Query insert
$sql = "INSERT INTO sub_menu (name, icon, url, ordinal_number, is_active, createdBy, menu_id) 
        VALUES ('$name','$icon','$url','$ordinal_number','$is_active', '$createdBy', '$menu_id')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Sub Menu berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan sub menu: ' . $conn->error]);
}

$conn->close();
