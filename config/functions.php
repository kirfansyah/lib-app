<?php
include 'database.php';

function check_access($role_id, $menu_id = null, $sub_menu_id = null)
{
    global $conn;
    $sql = "SELECT * FROM user_access WHERE grup_user_id = $role_id";

    if ($sub_menu_id) {
        $sql .= " AND sub_menu_id = $sub_menu_id";
    } elseif ($menu_id) {
        $sql .= " AND menu_id = $menu_id";
    }

    $result = $conn->query($sql);
    return $result->num_rows > 0;
}

function executeQuery($conn, $query)
{
    $result = $conn->query($query);
    if (!$result) {
        die("Query Error: " . $conn->error . "<br>Query: " . $query);
    }
    return $result;
}

function sanitizeUrl($baseUrl, $relativeUrl)
{

    $cleanBaseUrl = rtrim($baseUrl, '/'); // Hapus slash di akhir baseUrl
    $cleanRelativeUrl = ltrim($relativeUrl, '/'); // Hapus slash di awal relativeUrl  
    $fullUrl = $cleanBaseUrl . '/' . $cleanRelativeUrl;

    return htmlspecialchars($fullUrl, ENT_QUOTES, 'UTF-8');
}

function formatUrlLabel($url)
{
    // Hilangkan slash di awal jika ada
    $cleanUrl = ltrim($url, '/');

    // Ubah huruf pertama menjadi kapital
    return ucfirst($cleanUrl);
}

function generateUUIDv4()
{
    $data = random_bytes(16);

    // Versi 4 (UUID)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
