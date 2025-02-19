<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';


// Tangkap data dari AJAX
$name          = $_POST['name'];
$id_number     = $_POST['id_number'];
$username      = $_POST['username'];
// $password   = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password
$password      = $_POST['password']; // Enkripsi password
$group_user_id = $_POST['group_user_id'];
$is_active     = $_POST['is_active'];
$createdBy     = $_SESSION['username'] ?? 'SYSTEM';

// Generate UUID v4
$uuid = generateUUIDv4();

// Query insert
$sql = "INSERT INTO users (name,uuid, id_number, username, password, group_user_id, is_active, createdBy) 
        VALUES ('$name','$uuid', '$id_number', '$username', '$password', '$group_user_id', '$is_active', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan user: ' . $conn->error]);
}

$conn->close();
