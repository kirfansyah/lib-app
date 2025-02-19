<?php
session_start();
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/config.php";

// Cek apakah user sudah login
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.html");
//     exit();
// }

// Ambil bagian URL setelah "/lib-app/"
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = "/lib-app/";
$relative_path = str_replace($base_path, "/", $request_uri);
$current_page = strtok($relative_path, '?'); // Hapus parameter query string

$role_id = $_SESSION['group_user_id']; // Ambil role user dari session
// $role_id = 1; // Ambil role user dari session

// Debugging untuk melihat halaman yang sedang diakses
// echo "Current Page: " . $current_page;
// die();

// Query untuk mengecek apakah role memiliki akses ke halaman ini
$query = "
    SELECT DISTINCT m.url FROM user_access ua
    JOIN menu m ON ua.menu_id = m.id where ua.group_user_id = '$role_id' AND m.url = '$current_page'
    UNION ALL
    SELECT DISTINCT sm.url FROM user_access ua
    JOIN sub_menu sm ON ua.sub_menu_id = sm.id where ua.group_user_id = '$role_id' AND sm.url = '$current_page'
    UNION ALL
    SELECT '/' AS url 
    WHERE EXISTS (
    SELECT 1 FROM user_access ua 
    WHERE ua.group_user_id = '1' AND '/' = '$current_page'
);
";

$result = mysqli_query($conn, $query);

// Cek apakah query berhasil dijalankan
if (!$result) {
    die("Query Error: " . mysqli_error($conn)); // Debugging jika query error
}

// Jika tidak ada hasil, redirect ke unauthorized.php
if (mysqli_num_rows($result) == 0) {
    header("Location: " . $baseUrl . 'forbidden-accesss');
    // die('ddd');
    exit();
}
