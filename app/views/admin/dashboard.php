<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Dashboard</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<!-- Statistik Cards -->
<div class="row">
    <!-- Total Produk Card -->
    <div class="col-xl-6 col-md-6 col-12">
        <div class="box">
            <div class="box-body d-flex align-items-center">
                <div class="d-flex align-items-center me-auto">
                    <div class="icon bg-primary-light rounded-circle w-60 h-60 text-center l-h-80">
                        <span class="fs-30 icon-Box2"><span class="path1"></span><span class="path2"></span></span>
                    </div>
                    <div class="ms-15">
                        <h5 class="mb-0">Total Produk</h5>
                        <p class="mb-0 text-mute fs-20 font-weight-600"><?= $totalProduk ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Nilai Stok Card -->
    <div class="col-xl-6 col-md-6 col-12">
        <div class="box">
            <div class="box-body d-flex align-items-center">
                <div class="d-flex align-items-center me-auto">
                    <div class="icon bg-success-light rounded-circle w-60 h-60 text-center l-h-80">
                        <span class="fs-30 icon-Money"><span class="path1"></span><span class="path2"></span></span>
                    </div>
                    <div class="ms-15">
                        <h5 class="mb-0">Total Nilai Stok</h5>
                        <p class="mb-0 text-mute fs-20 font-weight-600">Rp <?= number_format($totalNilaiStok, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data dan Grafik -->
<div class="row">
    <!-- Produk Terbaru -->
    <div class="col-xl-7 col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Produk Terbaru</h4>
                <div class="box-controls pull-right">
                    <a href="<?= BASE_URL ?>admin/produk" class="btn btn-primary btn-sm">
                        <i class="ti-eye me-5"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($produkTerbaru)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data produk</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($produkTerbaru as $produk): ?>
                                    <tr>
                                        <td><?= $produk['id'] ?></td>
                                        <td><?= $produk['nama_produk'] ?></td>
                                        <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                                        <td><?= $produk['stok'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Stok Produk -->
    <div class="col-xl-5 col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Grafik Stok Produk</h4>
            </div>
            <div class="box-body">
                <div id="chartStokContainer" style="height: 350px;">
                    <canvas id="chartStok"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart dari PHP
    var labels = <?= json_encode(array_column($chartData, 'nama_produk')) ?>;
    var data = <?= json_encode(array_column($chartData, 'stok')) ?>;
    
    // Buat chart
    var ctx = document.getElementById('chartStok').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Stok Produk',
                data: data,
                backgroundColor: [
                    'rgba(78, 115, 223, 0.5)',
                    'rgba(28, 200, 138, 0.5)',
                    'rgba(54, 185, 204, 0.5)',
                    'rgba(246, 194, 62, 0.5)',
                    'rgba(231, 74, 59, 0.5)',
                    'rgba(133, 135, 150, 0.5)',
                    'rgba(105, 108, 255, 0.5)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)',
                    'rgba(133, 135, 150, 1)',
                    'rgba(105, 108, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw + ' unit';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        borderDash: [2, 2]
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script> 