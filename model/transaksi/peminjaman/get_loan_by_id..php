<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();

$id = intval($_POST['id_peminjaman']);

$query = mysqli_query($conn, "SELECT A.*, B.nama_member FROM transaksi_peminjaman A LEFT JOIN member_perpus B ON A.id_member = B.id_member WHERE A.id_peminjaman = $id LIMIT 1");

if (!$query || mysqli_num_rows($query) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}

$data = mysqli_fetch_assoc($query);

// Ambil detail buku
$qDetail = mysqli_query($conn, "
    SELECT D.id_detail, D.id_buku, C.judul_buku, D.status, D.tanggal_kembali, D.denda
    FROM detail_peminjaman D
    LEFT JOIN master_buku C ON D.id_buku = C.id_buku
    WHERE D.id_peminjaman = $id
    ORDER BY C.id_buku
");

$detail_buku = [];
while ($row = mysqli_fetch_assoc($qDetail)) {
    $detail_buku[] = $row;
}

$data['detail_buku'] = $detail_buku;

echo json_encode(['status' => 'success', 'data' => $data]);
