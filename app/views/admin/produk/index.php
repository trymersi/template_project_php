<!-- Custom CSS untuk memperbaiki horizontal scroll -->
<style>
    /* Perbaikan horizontal scroll */
    .dataTables_wrapper {
        width: 100%;
        overflow-x: hidden;
    }
    
    .dataTables_wrapper .dataTables_paginate {
        width: auto;
        white-space: nowrap;
    }
    
    .dataTables_wrapper .dataTables_info {
        white-space: normal;
    }
    
    /* Memastikan DataTable responsive */
    .table-responsive {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Perbaikan untuk pagination container */
    div.dataTables_wrapper div.row {
        margin: 0;
        width: 100%;
    }
    
    /* Mengatur ulang ukuran pada pagination element */
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate {
        width: auto;
        float: none;
    }
    
    @media screen and (max-width: 767px) {
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: center;
        }
    }
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Produk</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
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
                <h4 class="box-title">Daftar Produk</h4>
                <div class="box-controls pull-right">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                        <i class="ti-plus me-5"></i> Tambah Produk
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="produkTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via Ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal center-modal fade" id="modalTambahProduk" tabindex="-1" role="dialog" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahProdukLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahProduk" method="post">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    
                    <div class="form-group mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga" name="harga" min="0" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal center-modal fade" id="modalEditProduk" tabindex="-1" role="dialog" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProdukLabel">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditProduk" method="post">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group mb-3">
                        <label for="edit_nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_harga" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="edit_harga" name="harga" min="0" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_stok" name="stok" min="0" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal center-modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fs-60 text-warning icon-Question"></i>
                    <h4 class="mt-15 mb-15">Apakah Anda yakin ingin menghapus produk ini?</h4>
                </div>
            </div>
            <div class="modal-footer modal-footer-uniform">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="<?= BASE_URL ?>admin/hapusProduk" method="post">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Page Specific Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk membersihkan modal
    function cleanupModal(modalId) {
        $(modalId).modal('hide');
        $(modalId).removeClass('show');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        console.log('Cleanup modal ' + modalId + ' dijalankan');
    }
    
    // Perbaikan tutup modal ketika tombol close atau batal diklik
    $('.btn-close, .modal .btn-default').on('click', function() {
        var modalId = '#' + $(this).closest('.modal').attr('id');
        cleanupModal(modalId);
    });
    
    // Setup global AJAX settings untuk CSRF
    $.ajaxSetup({
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
    
    // Initialize DataTable
    var produkTable = $('#produkTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= BASE_URL ?>admin/getProdukData',
            type: 'GET'
        },
        columns: [
            { data: 0 }, // ID
            { data: 1 }, // Nama Produk
            { data: 2 }, // Harga
            { data: 3 }, // Stok
            { 
                data: 4,  // Aksi
                orderable: false,
                searchable: false
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
    
    // Fungsi untuk mendapatkan CSRF token baru
    function refreshCsrfToken() {
        $.ajax({
            url: '<?= BASE_URL ?>admin/getNewCsrfToken',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('input[name="<?= CSRF_TOKEN_NAME ?>"]').val(response.token);
                }
            }
        });
    }
    
    // Tambah Produk Form Submission
    $('#formTambahProduk').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= BASE_URL ?>admin/produk/tambah',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Reset form
                    $('#formTambahProduk').trigger('reset');
                    
                    // Tutup modal
                    cleanupModal('#modalTambahProduk');
                    
                    // Refresh DataTable
                    produkTable.ajax.reload();
                    
                    // Refresh CSRF Token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Log error
                console.error('Error:', error);
                
                // Tampilkan pesan error
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });
    
    // Populate Edit Form
    $('#produkTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var harga = $(this).data('harga');
        var stok = $(this).data('stok');
        var deskripsi = $(this).data('deskripsi');
        
        $('#edit_id').val(id);
        $('#edit_nama_produk').val(nama);
        $('#edit_harga').val(harga);
        $('#edit_stok').val(stok);
        $('#edit_deskripsi').val(deskripsi);
        
        $('#modalEditProduk').modal('show');
    });
    
    // Edit Produk Form Submission
    $('#formEditProduk').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= BASE_URL ?>admin/produk/edit',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Reset form
                    $('#formEditProduk').trigger('reset');
                    
                    // Tutup modal
                    cleanupModal('#modalEditProduk');
                    
                    // Refresh DataTable
                    produkTable.ajax.reload();
                    
                    // Refresh CSRF Token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Log error
                console.error('Error:', error);
                
                // Tampilkan pesan error
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });
    
    // Show Delete Modal
    $('#produkTable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteModal').modal('show');
    });
    
    // Delete Produk Form Submission
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Tutup modal
                    cleanupModal('#deleteModal');
                    
                    // Refresh DataTable
                    produkTable.ajax.reload();
                    
                    // Refresh CSRF Token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Log error
                console.error('Error:', error);
                
                // Tampilkan pesan error
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });
});
</script> 