<?php
// Menyertakan file routes.php untuk mengambil routing
$routes = include('config/routes.php');



// Mendapatkan URI yang diminta
$request_uri = $_SERVER['REQUEST_URI'];

// Mengambil nama folder aplikasi secara otomatis
$base_path = dirname($_SERVER['SCRIPT_NAME']); // Ambil nama subfolder aplikasi

// Menghapus base_path dari URI yang diminta
$request_uri = str_replace($base_path, '', $request_uri);


// Menghapus query string jika ada
$request_uri = strtok($request_uri, '?');

// print_r($request_uri);
// die;
// Mengecek apakah route ada di dalam routing
if (isset($routes[$request_uri])) {
    include $routes[$request_uri];
} else {
    include("404.php");
}
