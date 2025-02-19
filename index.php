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

// Cek apakah request memiliki parameter dinamis
$found = false;
foreach ($routes as $route => $file) {
    $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route); // Ubah {param} jadi regex
    if (preg_match("#^" . $pattern . "$#", $request_uri, $matches)) {
        array_shift($matches); // Hapus match pertama (karena itu adalah URL penuh)
        $_GET['params'] = $matches; // Simpan parameter dalam $_GET
        include $file;
        $found = true;
        break;
    }
}

// Jika tidak ditemukan, tampilkan halaman 404
if (!$found) {
    include("404.php");
}
