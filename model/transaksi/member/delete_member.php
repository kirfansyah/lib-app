<?php
require_once __DIR__ . "/../../../config/database.php";

if (!isset($_POST['id_member']) || empty($_POST['id_member'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid atau tidak dikirim']);
    exit();
}

$id_member = mysqli_real_escape_string($conn, $_POST['id_member']);

// Mulai transaction
$conn->begin_transaction();

try {
    // 1. Ambil semua id_peminjaman milik member ini
    $sql_get = "SELECT id_peminjaman FROM transaksi_peminjaman WHERE id_member = '$id_member'";
    $result = $conn->query($sql_get);

    $ids = [];
    while ($row = $result->fetch_assoc()) {
        $ids[] = $row['id_peminjaman'];
    }

    // 2. Hapus detail_peminjaman berdasarkan id_peminjaman
    if (!empty($ids)) {
        $ids_str = implode(',', $ids);
        $conn->query("DELETE FROM detail_peminjaman WHERE id_peminjaman IN ($ids_str)");
    }

    // 3. Hapus transaksi_peminjaman
    $conn->query("DELETE FROM transaksi_peminjaman WHERE id_member = '$id_member'");

    // 4. Hapus member
    $conn->query("DELETE FROM member_perpus WHERE id_member = '$id_member'");

    // Commit
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Member dan data terkait berhasil dihapus']);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus: ' . $e->getMessage()]);
}

$conn->close();