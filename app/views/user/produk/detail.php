<?php 
// Include header
require_once VIEW_PATH . 'user/layouts/header.php'; 
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Produk</h5>
        <a href="<?= BASE_URL ?>user/produk" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4"><?= $produk['nama_produk'] ?></h4>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">ID Produk</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext"><?= $produk['id'] ?></div>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Nama Produk</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext"><?= $produk['nama_produk'] ?></div>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Harga</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Stok</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext"><?= $produk['stok'] ?> unit</div>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Tanggal Ditambahkan</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext"><?= (new \core\Helper)->formatDate($produk['created_at'], true) ?></div>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label">Terakhir Diupdate</label>
                            <div class="col-md-8">
                                <div class="form-control-plaintext"><?= (new \core\Helper)->formatDate($produk['updated_at'], true) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Include footer
require_once VIEW_PATH . 'user/layouts/footer.php'; 
?> 