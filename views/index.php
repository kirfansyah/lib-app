<?php require_once __DIR__ . "/templates/header.php"; ?>
<?php require_once __DIR__ . "/templates/navbar.php"; ?>
<?php require_once __DIR__ . "/templates/sidebar.php"; ?>

<?php
// Ambil data statistik
$totalBuku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM master_buku WHERE is_active = 1"))['total'];
$totalMember = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM member_perpus WHERE is_active = 1"))['total'];
$totalPinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi_peminjaman WHERE status = 'dipinjam'"))['total'];
$totalKembali = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi_peminjaman WHERE status = 'dikembalikan'"))['total'];
$totalDenda = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(denda),0) as total FROM detail_peminjaman"))['total'];
$totalKategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM master_kategori WHERE is_active = 1"))['total'];

// Peminjaman aktif terbaru
$recentLoans = mysqli_query($conn, "
    SELECT tp.id_peminjaman, mp.nama_member, tp.tanggal_pinjam, tp.tanggal_pengembalian_seharusnya, tp.status,
           COUNT(dp.id_detail) as jumlah_buku
    FROM transaksi_peminjaman tp
    LEFT JOIN member_perpus mp ON tp.id_member = mp.id_member
    LEFT JOIN detail_peminjaman dp ON tp.id_peminjaman = dp.id_peminjaman
    GROUP BY tp.id_peminjaman
    ORDER BY tp.createdAt DESC
    LIMIT 5
");

// Buku per kategori
$bukuPerKategori = mysqli_query($conn, "
    SELECT mk.nama_kategori, COUNT(mb.id_buku) as total
    FROM master_kategori mk
    LEFT JOIN master_buku mb ON mk.id_kategori = mb.id_kategori AND mb.is_active = 1
    WHERE mk.is_active = 1
    GROUP BY mk.id_kategori
    ORDER BY total DESC
    LIMIT 6
");

$kategoriLabels = [];
$kategoriData = [];
while ($row = mysqli_fetch_assoc($bukuPerKategori)) {
    $kategoriLabels[] = $row['nama_kategori'];
    $kategoriData[] = (int)$row['total'];
}
?>

<style>
.stat-card {
    border-radius: 16px;
    padding: 24px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    transition: transform 0.2s;
    margin-bottom: 20px;
}
.stat-card:hover { transform: translateY(-4px); }
.stat-card .icon {
    position: absolute; right: 20px; top: 20px;
    opacity: 0.25; font-size: 56px;
}
.stat-card h2 { font-size: 36px; font-weight: 700; margin: 0; }
.stat-card p { margin: 4px 0 0; font-size: 14px; opacity: 0.9; }
.stat-card small { font-size: 12px; opacity: 0.7; }
.bg-grad-1 { background: linear-gradient(135deg, #667eea, #764ba2); }
.bg-grad-2 { background: linear-gradient(135deg, #f093fb, #f5576c); }
.bg-grad-3 { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.bg-grad-4 { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.bg-grad-5 { background: linear-gradient(135deg, #fa709a, #fee140); }
.bg-grad-6 { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }

.dashboard-title {
    font-size: 22px; font-weight: 600; margin-bottom: 6px;
}
.dashboard-sub {
    font-size: 13px; color: #888; margin-bottom: 24px;
}
.card-section {
    background: white; border-radius: 16px;
    padding: 20px 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    margin-bottom: 20px;
}
.card-section h6 {
    font-size: 15px; font-weight: 600; margin-bottom: 16px;
    padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;
}
.badge-status {
    padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
}
.badge-dipinjam { background: #fff3cd; color: #856404; }
.badge-dikembalikan { background: #d1e7dd; color: #0f5132; }
table.dash-table { width: 100%; font-size: 13px; }
table.dash-table th { color: #888; font-weight: 600; padding: 6px 10px; border-bottom: 1px solid #f0f0f0; }
table.dash-table td { padding: 10px 10px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
table.dash-table tr:last-child td { border-bottom: none; }
.denda-total { font-size: 22px; font-weight: 700; color: #dc3545; }
</style>

<div class="page-wrapper">
    <div class="content" style="padding: 28px;">

        <!-- Header -->
        <div class="dashboard-title">📚 Dashboard BookVault</div>
        <div class="dashboard-sub">Selamat datang, <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?> — <?= date('l, d F Y') ?></div>

        <!-- Stat Cards -->
        <div class="row">
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-1">
                    <div class="icon"><i class="fa fa-book"></i></div>
                    <h2><?= $totalBuku ?></h2>
                    <p>Total Buku</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-2">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <h2><?= $totalMember ?></h2>
                    <p>Member Aktif</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-3">
                    <div class="icon"><i class="fa fa-hand-holding"></i></div>
                    <h2><?= $totalPinjam ?></h2>
                    <p>Sedang Dipinjam</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-4">
                    <div class="icon"><i class="fa fa-check-circle"></i></div>
                    <h2><?= $totalKembali ?></h2>
                    <p>Dikembalikan</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-5">
                    <div class="icon"><i class="fa fa-tags"></i></div>
                    <h2><?= $totalKategori ?></h2>
                    <p>Kategori</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-6">
                <div class="stat-card bg-grad-6">
                    <div class="icon"><i class="fa fa-money-bill"></i></div>
                    <h2 style="font-size:22px;">Rp<?= number_format($totalDenda,0,',','.') ?></h2>
                    <p>Total Denda</p>
                </div>
            </div>
        </div>

        <!-- Charts + Recent -->
        <div class="row">
            <!-- Chart -->
            <div class="col-lg-5">
                <div class="card-section">
                    <h6>📊 Buku per Kategori</h6>
                    <canvas id="kategoriChart" height="220"></canvas>
                </div>
            </div>

            <!-- Recent Loans -->
            <div class="col-lg-7">
                <div class="card-section">
                    <h6>🕐 Transaksi Terbaru</h6>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Tgl Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Buku</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($loan = mysqli_fetch_assoc($recentLoans)): ?>
                            <?php
                                $isOverdue = $loan['status'] === 'dipinjam' && strtotime($loan['tanggal_pengembalian_seharusnya']) < time();
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($loan['nama_member'] ?: '-') ?></strong></td>
                                <td><?= $loan['tanggal_pinjam'] ?></td>
                                <td style="color: <?= $isOverdue ? '#dc3545' : 'inherit' ?>; font-weight: <?= $isOverdue ? '600' : 'normal' ?>">
                                    <?= $loan['tanggal_pengembalian_seharusnya'] ?>
                                    <?= $isOverdue ? '⚠️' : '' ?>
                                </td>
                                <td><?= $loan['jumlah_buku'] ?> buku</td>
                                <td>
                                    <span class="badge-status badge-<?= $loan['status'] ?>">
                                        <?= $loan['status'] === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . "/templates/footbar.php"; ?>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script> -->
 <script src="/assets/js/chart.min.js"></script>
<script>
const ctx = document.getElementById('kategoriChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($kategoriLabels) ?>,
        datasets: [{
            data: <?= json_encode($kategoriData) ?>,
            backgroundColor: ['#667eea','#f5576c','#4facfe','#43e97b','#fa709a','#a18cd1'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } }
        },
        cutout: '60%'
    }
});
</script>

<?php require_once __DIR__ . "/templates/footbarend.php"; ?>