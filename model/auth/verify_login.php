<?php
require_once __DIR__ . "/../../config/database.php";

session_start();

$username = $_POST['username'];
$password = $_POST['password']; // Tidak di-hash

$sql = "SELECT * FROM vwmstuser WHERE username='$username' AND password='$password' AND is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Simpan sesi
    $_SESSION['user_id']       = $user['id'];
    $_SESSION['username']      = $user['username'];
    $_SESSION['full_name']     = $user['name'];
    $_SESSION['group_user_id'] = $user['group_user_id'];
    $_SESSION['id_number']     = $user['id_number'];
    $_SESSION['leveluser']     = $user['leveluser'];

    // // Simpan session_id ke database
    // $session_id = session_id();
    // $conn->query("UPDATE users SET session_id='$session_id' WHERE id=" . $user['id']);

    echo json_encode(["status" => "success", "message" => "Login successful!", "full_name" => $user['name']]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid username or password!"]);
}
