<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_peminjaman']) || empty($_POST['id_peminjaman'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_peminjaman = mysqli_real_escape_string($conn, $_POST['id_peminjaman']);

$sql    = "SELECT * FROM vwmstpeminjaman WHERE id_peminjaman='$id_peminjaman'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit();
}

$row = $result->fetch_assoc();

// Parse detail_buku dari string → array
$detail_buku = [];
if (!empty($row['detail_buku'])) {
    $bukus = explode(';;', $row['detail_buku']);
    foreach ($bukus as $b) {
        $parts = explode('|', $b);
        $detail_buku[] = [
            'id_detail'      => $parts[0] ?? '',
            'id_buku'        => $parts[1] ?? '',
            'judul_buku'     => $parts[2] ?? '',
            'status'         => $parts[3] ?? 'dipinjam',
            'tanggal_kembali' => $parts[4] ?? '',
            'denda'          => $parts[5] ?? 0,
        ];
    }
}

$row['detail_buku'] = $detail_buku;

echo json_encode(['status' => 'success', 'data' => $row]);

$conn->close();
