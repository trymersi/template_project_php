<?php 
// Include header
require_once VIEW_PATH . 'admin/layouts/header.php'; 
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Produk</h5>
        <a href="<?= BASE_URL ?>admin/produk" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="<?= BASE_URL ?>admin/editProduk/<?= $produk['id'] ?>" method="post">
            <!-- CSRF Token -->
            <?php $csrf = new \core\CSRF(); ?>
            <?= $csrf->getTokenField() ?>
            
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control <?= isset($errors['nama_produk']) ? 'is-invalid' : '' ?>" id="nama_produk" name="nama_produk" value="<?= $produk['nama_produk'] ?>" required>
                <?php if (isset($errors['nama_produk'])): ?>
                    <div class="invalid-feedback"><?= $errors['nama_produk'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control <?= isset($errors['harga']) ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= $produk['harga'] ?>" min="0" required>
                <?php if (isset($errors['harga'])): ?>
                    <div class="invalid-feedback"><?= $errors['harga'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control <?= isset($errors['stok']) ? 'is-invalid' : '' ?>" id="stok" name="stok" value="<?= $produk['stok'] ?>" min="0" required>
                <?php if (isset($errors['stok'])): ?>
                    <div class="invalid-feedback"><?= $errors['stok'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<?php 
// Include footer
require_once VIEW_PATH . 'admin/layouts/footer.php'; 
?> 