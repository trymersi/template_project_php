<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title"><?= $isAdmin ? 'Dashboard Admin' : 'Dashboard User' ?></h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?><?= $isAdmin ? 'admin' : 'user' ?>/dashboard">
                                <i class="mdi mdi-home-outline"></i>
                            </a>
                        </li>
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
    <?php if ($isAdmin): ?>
    <!-- Total Produk Card - Admin -->
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

    <!-- Total Nilai Stok Card - Admin -->
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
    <?php else: ?>
    <!-- Total Produk Card - User -->
    <div class="col-xl-3 col-md-6 col-12">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="icon bg-primary-light rounded-circle w-60 h-60 text-center l-h-60">
                        <span class="fs-30 icon-Bulb1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                    </div>
                    <div class="ms-15">
                        <h5 class="mb-0">Total Produk</h5>
                        <p class="mb-0 text-fade fs-12"><?= $totalProduk ?> produk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Data dan Grafik -->
<div class="row">
    <?php if ($isAdmin): ?>
    <!-- Produk Terbaru - Admin -->
    <div class="col-xl-7 col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Produk Terbaru</h4>
                <div class="box-controls pull-right">
                    <a href="<?= BASE_URL ?>produk" class="btn btn-primary btn-sm">
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

    <!-- Grafik Stok Produk - Admin -->
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
    <?php else: ?>
    <!-- Produk Terbaru - User -->
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Produk Terbaru</h4>
            </div>
            <div class="box-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produkTerbaru)): ?>
                                <?php foreach ($produkTerbaru as $key => $row): ?>
                                    <tr>
                                        <th scope="row"><?= $key + 1 ?></th>
                                        <td><?= $row['nama_produk'] ?></td>
                                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>produk/detail/<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada produk terbaru</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Produk - User -->
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Statistik Produk</h4>
            </div>
            <div class="box-body">
                <canvas id="productChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Chart.js initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($isAdmin): ?>
    // Data untuk chart admin
    var labels = <?= json_encode(array_column($chartData, 'nama_produk')) ?>;
    var data = <?= json_encode(array_column($chartData, 'stok')) ?>;
    
    // Buat chart admin
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
    <?php else: ?>
    // Chart data for user
    var productLabels = <?= json_encode(array_column($chartData, 'nama_produk')) ?>;
    var productStocks = <?= json_encode(array_column($chartData, 'stok')) ?>;
    var productPrices = <?= json_encode(array_column($chartData, 'harga')) ?>;
    
    // Create Chart for user
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Stok Produk',
                data: productStocks,
                backgroundColor: 'rgba(60, 141, 188, 0.7)',
                borderColor: 'rgba(60, 141, 188, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    <?php endif; ?>
});
</script> 