<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();
// Tangkap data dari AJAX
$nama_member = $_POST['nama_member'];
$email       = $_POST['email'];
$no_hp       = $_POST['no_hp'];
$alamat      = $_POST['alamat'];
$is_active   = $_POST['is_active'];
$createdBy   = $_SESSION['username'] ?? 'SYSTEM';


// Query insert
$sql = "INSERT INTO member_perpus (nama_member,email,no_hp,alamat, is_active, createdBy) 
        VALUES ('$nama_member','$email','$no_hp','$alamat','$is_active', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Member berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan member: ' . $conn->error]);
}

$conn->close();
