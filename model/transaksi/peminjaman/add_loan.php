<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();

$id_member                       = $_POST['id_member'];
$id_bukus                        = $_POST['id_buku']; // array
$tanggal_pinjam                  = date('Y-m-d', strtotime($_POST['tanggal_pinjam']));
$tanggal_pengembalian_seharusnya = date('Y-m-d', strtotime($_POST['tanggal_pengembalian_seharusnya']));
$createdBy                       = $_SESSION['username'] ?? 'SYSTEM';

// ================= VALIDASI =================
if (!$id_member || empty($id_bukus)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
    exit;
}

$id_member    = mysqli_real_escape_string($conn, $id_member);
$id_bukus_clean = array_unique(array_map('intval', $id_bukus));

// ================= CEK STOK =================
foreach ($id_bukus_clean as $id_buku) {
    $cek = mysqli_query($conn, "SELECT stok FROM master_buku WHERE id_buku = $id_buku");
    $row = mysqli_fetch_assoc($cek);

    if (!$row) {
        echo json_encode(["status" => "error", "message" => "Buku tidak ditemukan (ID: $id_buku)"]);
        exit;
    }
    if ($row['stok'] <= 0) {
        echo json_encode(["status" => "error", "message" => "Stok buku habis (ID: $id_buku)"]);
        exit;
    }
}

// ================= SIMPAN HEADER TRANSAKSI =================
$sql_header = "INSERT INTO transaksi_peminjaman 
    (id_member, tanggal_pinjam, tanggal_pengembalian_seharusnya, status, createdBy, updateBy) 
    VALUES 
    ('$id_member', '$tanggal_pinjam', '$tanggal_pengembalian_seharusnya', 'dipinjam', '$createdBy', '$createdBy')";

$insert_header = mysqli_query($conn, $sql_header);

if (!$insert_header) {
    echo json_encode(["status" => "error", "message" => "Gagal simpan transaksi: " . mysqli_error($conn)]);
    exit;
}

$id_peminjaman = mysqli_insert_id($conn); // ambil id_peminjaman yang baru dibuat

// ================= SIMPAN DETAIL + KURANGI STOK =================
foreach ($id_bukus_clean as $id_buku) {

    // Insert ke detail_peminjaman
    $sql_detail = "INSERT INTO detail_peminjaman (id_peminjaman, id_buku) 
                   VALUES ('$id_peminjaman', '$id_buku')";

    $insert_detail = mysqli_query($conn, $sql_detail);

    if (!$insert_detail) {
        echo json_encode(["status" => "error", "message" => "Gagal simpan detail: " . mysqli_error($conn)]);
        exit;
    }

    // Kurangi stok
    mysqli_query($conn, "UPDATE master_buku SET stok = stok - 1 WHERE id_buku = $id_buku");
}

echo json_encode(["status" => "success", "message" => "Transaksi berhasil disimpan"]);
$conn->close();
