<?php
// session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpus";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
