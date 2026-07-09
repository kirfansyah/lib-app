<?php
require_once __DIR__ . "/../../../config/database.php";

$default = '0000-00-00 00:00:00';
$sql     = "SELECT * FROM vwmstpeminjaman ORDER BY id_peminjaman DESC";
$result  = $conn->query($sql);

$data = [];
$no   = 1;

while ($row = $result->fetch_assoc()) {

    // Parse detail_buku → tampil list per buku + statusnya
    $judul_list = '';
    $detail_buku = [];

    if (!empty($row['detail_buku'])) {
        $bukus = explode(';;', $row['detail_buku']);
        foreach ($bukus as $b) {
            $parts  = explode('|', $b);
            $judul  = $parts[2] ?? '-';
            $status = $parts[3] ?? 'dipinjam';
            $badge  = $status == 'dikembalikan'
                ? '<span class="badges bg-lightgreen">Dikembalikan</span>'
                : '<span class="badges bg-lightred">Dipinjam</span>';
            $judul_list .= '<div>' . htmlspecialchars($judul) . ' ' . $badge . '</div>';
        }
    }

    $status_header = $row['status'] == 'dikembalikan'
        ? '<span class="badges bg-lightgreen">Dikembalikan</span>'
        : '<span class="badges bg-lightred">Dipinjam</span>';

    $tanggal_pinjam                  = date('d-m-Y', strtotime($row['tanggal_pinjam']));
    $tanggal_pengembalian_seharusnya = date('d-m-Y', strtotime($row['tanggal_pengembalian_seharusnya']));
    $total_denda                     = 'Rp ' . number_format($row['total_denda'] ?? 0, 0, ',', '.');
    $create_by                       = $row['createdBy'] . '<br>' . ($row['createdAt'] == $default ? '' : date('d-m-Y H:i:s', strtotime($row['createdAt'])));
    $update_by                       = $row['updateBy']  . '<br>' . ($row['updateAt'] == $default ? '' : date('d-m-Y H:i:s', strtotime($row['updateAt'])));

    $actions = $row['status'] != 'dikembalikan'
        ? '<a class="me-3 edit-data" href="#" data-id="' . $row['id_peminjaman'] . '" data-bs-toggle="modal" data-bs-target="#modalKembali">
               <img src="assets/img/icons/edit.svg" alt="img">
           </a>'
        : '-';

    $data[] = [
        $no++,
        $row['nama_member'],
        $judul_list,
        $status_header,
        $tanggal_pinjam,
        $tanggal_pengembalian_seharusnya,
        $total_denda,
        $create_by,
        $update_by,
        $actions,
    ];
}

echo json_encode(["data" => $data]);
