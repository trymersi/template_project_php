<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Dashboard User</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>user/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
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
    <!-- Tambahkan card lain di sini sesuai kebutuhan -->
</div>

<div class="row">
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
                                            <a href="<?= BASE_URL ?>user/produk/detail/<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
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
</div>

<div class="row">
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart data
    var productLabels = <?= json_encode(array_column($chartData, 'nama_produk')) ?>;
    var productStocks = <?= json_encode(array_column($chartData, 'stok')) ?>;
    var productPrices = <?= json_encode(array_column($chartData, 'harga')) ?>;
    
    // Create Chart
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
});
</script> 