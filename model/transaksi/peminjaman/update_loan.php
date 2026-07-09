<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan']);
    exit;
}

$id_peminjaman  = intval($_POST['id_peminjaman']);
$id_details     = $_POST['id_detail'] ?? []; // array id_detail yang dicentang
$updatedBy      = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');
$tanggal_kembali = date('Y-m-d');

if (empty($id_details)) {
    echo json_encode(['status' => 'error', 'message' => 'Pilih minimal 1 buku yang dikembalikan']);
    exit;
}

// 1. AMBIL DATA HEADER
$query = mysqli_query($conn, "SELECT tanggal_pengembalian_seharusnya FROM transaksi_peminjaman WHERE id_peminjaman = $id_peminjaman LIMIT 1");
if (!$query || mysqli_num_rows($query) == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Transaksi tidak ditemukan']);
    exit;
}
$header = mysqli_fetch_assoc($query);
$tgl_seharusnya = strtotime($header['tanggal_pengembalian_seharusnya']);
$tgl_kembali    = strtotime($tanggal_kembali);
$selisih_hari   = max(0, floor(($tgl_kembali - $tgl_seharusnya) / 86400));
$denda_per_buku = $selisih_hari * 2000; // Rp 2.000/hari/buku

// 2. UPDATE SETIAP BUKU YANG DICENTANG
foreach ($id_details as $id_detail) {
    $id_detail = intval($id_detail);

    // Ambil id_buku & cek status
    $qDetail = mysqli_query($conn, "SELECT id_buku, status FROM detail_peminjaman WHERE id_detail = $id_detail LIMIT 1");
    $detail  = mysqli_fetch_assoc($qDetail);

    if (!$detail || $detail['status'] === 'dikembalikan') continue;

    // Update detail
    mysqli_query($conn, "
        UPDATE detail_peminjaman SET 
            status          = 'dikembalikan',
            tanggal_kembali = '$tanggal_kembali',
            denda           = $denda_per_buku
        WHERE id_detail = $id_detail
    ");

    // Kembalikan stok
    mysqli_query($conn, "UPDATE master_buku SET stok = stok + 1 WHERE id_buku = {$detail['id_buku']}");
}

// 3. CEK APAKAH SEMUA BUKU SUDAH DIKEMBALIKAN
$qCek    = mysqli_query($conn, "SELECT COUNT(*) as sisa FROM detail_peminjaman WHERE id_peminjaman = $id_peminjaman AND status = 'dipinjam'");
$cek     = mysqli_fetch_assoc($qCek);
$status_header = $cek['sisa'] == 0 ? 'dikembalikan' : 'dipinjam';

// 4. UPDATE HEADER
mysqli_query($conn, "
    UPDATE transaksi_peminjaman SET 
        status   = '$status_header',
        updateBy = '$updatedBy',
        updateAt = NOW()
    WHERE id_peminjaman = $id_peminjaman
");

echo json_encode([
    'status'  => 'success',
    'message' => 'Berhasil dikembalikan',
    'sisa'    => $cek['sisa']
]);

$conn->close();
