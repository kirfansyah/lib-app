<?php
require_once __DIR__ . "/../../../config/database.php";
require_once __DIR__ . '/../../../config/functions.php';
session_start();
// Tangkap data dari AJAX
$id_member                       = $_POST['id_member'];
$id_buku                         = $_POST['id_buku'];
$tanggal_pinjam                  = date('Y-m-d', strtotime($_POST['tanggal_pinjam']));
$tanggal_pengembalian_seharusnya = date('Y-m-d', strtotime($_POST['tanggal_pengembalian_seharusnya']));
$createdBy                       = $_SESSION['username'] ?? 'SYSTEM';


// Query insert
$sql = "INSERT INTO transaksi_peminjaman (id_member,id_buku,tanggal_pinjam,tanggal_pengembalian_seharusnya,status, createdBy) 
        VALUES ('$id_member','$id_buku','$tanggal_pinjam','$tanggal_pengembalian_seharusnya','dipinjam', '$createdBy')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data: ' . $conn->error]);
}

$conn->close();
