<?php

require_once __DIR__ . "/../../../config/database.php";
$default = '0000-00-00 00:00:00';
$sql = "SELECT * FROM vwmstpeminjaman ORDER BY id_peminjaman DESC";
$result = $conn->query($sql);

$data = array();
$no = 1;
while ($row = $result->fetch_assoc()) {
    // Pisahkan setiap kolom ke dalam variabel agar lebih fleksibel
    $nomor                           = $no++;
    $nama_member                     = $row['nama_member'];
    $judul_buku                      = $row['judul_buku'];
    $status                          = $row['status'] == 'dikembalikan' ? '<span class="badges bg-lightgreen">' . ucfirst($row['status']) . '</span>' : '<span class="badges bg-lightred">' . ucfirst($row['status']) . '</span>';
    $tanggal_pinjam                  = date('d-m-Y', strtotime($row['tanggal_pinjam']));
    $tanggal_pengembalian_seharusnya = date('d-m-Y', strtotime($row['tanggal_pengembalian_seharusnya']));
    $tanggal_kembali                 = date('d-m-Y', strtotime($row['tanggal_kembali']));
    $denda                           = "Rp " . number_format($row['denda'], 0, ',', '.');
    $create_by                       = $row['createdBy']  . '<br>' . ($row['createdAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['createdAt'])));
    $update_by                       = $row['updateBy']  . '<br>' . ($row['updateAt'] == $default ? '' : date('d-m-Y H:is', strtotime($row['updateAt'])));
    $actions                         = ' <a class="me-3 edit-data" href="#" id="edit-data" data-id="' . $row['id_peminjaman'] . '" data-bs-toggle="modal" data-bs-target="#create">
                                        <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="confirm-text delete-data" href="#" id="delete-data" data-id="' . $row['id_peminjaman'] . '">
                                        <img src="assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    ';

    // Tambahkan ke array data
    $data[] = array(
        $nomor,
        $nama_member,
        $judul_buku,
        $status,
        $tanggal_pinjam,
        $tanggal_pengembalian_seharusnya,
        $tanggal_kembali,
        $denda,
        $create_by,
        $update_by,
        $actions,
    );
}

$response = array("data" => $data);

echo json_encode($response);
