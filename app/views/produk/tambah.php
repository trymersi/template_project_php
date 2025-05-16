<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title"><?= $title ?></h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?><?= $isAdmin ? 'admin' : 'user' ?>/dashboard">
                                <i class="mdi mdi-home-outline"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>produk">Daftar Produk</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Tambah Produk Baru</h4>
                <div class="box-controls pull-right">
                    <a href="<?= BASE_URL ?>produk" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left me-5"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <form action="<?= BASE_URL ?>produk/tambah" method="post">
                            <!-- CSRF Token -->
                            <?php $csrf = new \core\CSRF(); ?>
                            <?= $csrf->getTokenField() ?>
                            
                            <div class="form-group mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['nama_produk']) ? 'is-invalid' : '' ?>" 
                                       id="nama_produk" name="nama_produk" 
                                       value="<?= $nama_produk ?? '' ?>" required>
                                <?php if (isset($errors['nama_produk'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nama_produk'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?= isset($errors['harga']) ? 'is-invalid' : '' ?>" 
                                       id="harga" name="harga" 
                                       value="<?= $harga ?? '' ?>" min="0" required>
                                <?php if (isset($errors['harga'])): ?>
                                    <div class="invalid-feedback"><?= $errors['harga'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?= isset($errors['stok']) ? 'is-invalid' : '' ?>" 
                                       id="stok" name="stok" 
                                       value="<?= $stok ?? '' ?>" min="0" required>
                                <?php if (isset($errors['stok'])): ?>
                                    <div class="invalid-feedback"><?= $errors['stok'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $deskripsi ?? '' ?></textarea>
                            </div>
                            
                            <div class="form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti-save me-5"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 