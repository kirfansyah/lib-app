<?php
require_once __DIR__ . "/../../../config/database.php";
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = mysqli_real_escape_string($conn, $_POST['id_peminjaman']);

    $tanggal_kembali = mysqli_real_escape_string(
        $conn,
        date('Y-m-d', strtotime($_POST['tanggal_kembali']))
    );

    $denda = mysqli_real_escape_string($conn, $_POST['denda']);
    $updatedBy = mysqli_real_escape_string($conn, $_SESSION['username'] ?? 'SYSTEM');

    // 🔥 1. AMBIL DATA PEMINJAMAN (1 ROW)
    $query = mysqli_query($conn, "
        SELECT id_bukus 
        FROM transaksi_peminjaman 
        WHERE id_peminjaman = '$id'
        LIMIT 1
    ");

    if (!$query || mysqli_num_rows($query) == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data peminjaman tidak ditemukan'
        ]);
        exit;
    }

    $row = mysqli_fetch_assoc($query);

    // 🔥 2. PECAH ID BUKU "33,44"
    $bukuList = explode(',', $row['id_bukus']);

    foreach ($bukuList as $id_buku) {

        $id_buku = trim($id_buku);

        if (!empty($id_buku)) {
            mysqli_query($conn, "
                UPDATE master_buku 
                SET stok = stok + 1 
                WHERE id_buku = '$id_buku'
            ");
        }
    }

    // 🔥 3. UPDATE TRANSAKSI
    $sql = "
        UPDATE transaksi_peminjaman SET 
            tanggal_kembali = '$tanggal_kembali',
            denda = '$denda',
            status = 'dikembalikan',
            updateBy = '$updatedBy',
            updateAt = NOW()
        WHERE id_peminjaman = '$id'
    ";

    if ($conn->query($sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Berhasil dikembalikan & stok buku ditambah'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $conn->error
        ]);
    }

    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode tidak diizinkan'
    ]);
}
