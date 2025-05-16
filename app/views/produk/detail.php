<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title"><?= $title ?></h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>dashboard">
                                <i class="mdi mdi-home-outline"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>produk">Daftar Produk</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
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
                <h4 class="box-title">Detail Produk</h4>
                <div class="box-controls pull-right">
                    <a href="<?= BASE_URL ?>produk" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left me-5"></i> Kembali
                    </a>
                    <a href="<?= BASE_URL ?>produk/edit/<?= $produk['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="ti-pencil me-5"></i> Edit
                    </a>
                    <?php if ($isAdmin): ?>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" 
                            data-id="<?= $produk['id'] ?>" 
                            data-nama="<?= $produk['nama_produk'] ?>">
                        <i class="ti-trash me-5"></i> Hapus
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th width="30%">ID Produk</th>
                                        <td width="70%"><?= $produk['id'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <td><?= $produk['nama_produk'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td><?= $produk['stok'] ?> unit</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td><?= $produk['deskripsi'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Ditambahkan</th>
                                        <td><?= (new \core\Helper)->formatDate($produk['created_at'], true) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diupdate</th>
                                        <td><?= (new \core\Helper)->formatDate($produk['updated_at'], true) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($isAdmin): ?>
<!-- Page Specific Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hapus produk
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus produk "' + nama + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= BASE_URL ?>produk/hapus',
                    type: 'POST',
                    data: {
                        id: id,
                        <?= CSRF_TOKEN_NAME ?>: '<?= $this->csrf->getToken() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.href = '<?= BASE_URL ?>produk';
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan pada server',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
<?php endif; ?> 