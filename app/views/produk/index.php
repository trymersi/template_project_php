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
                    <table id="produkTable" class="table table-hover">
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
<div class="modal fade" id="modalTambahProduk" tabindex="-1" role="dialog" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahProdukLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahProduk">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    
                    <div class="form-group mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        <div class="invalid-feedback" id="error-nama_produk"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="harga" name="harga" min="0" required>
                        <div class="invalid-feedback" id="error-harga"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                        <div class="invalid-feedback" id="error-stok"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="modalEditProduk" tabindex="-1" role="dialog" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProdukLabel">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditProduk">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?= $csrf->getTokenField() ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group mb-3">
                        <label for="edit_nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required>
                        <div class="invalid-feedback" id="error-edit_nama_produk"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" min="0" required>
                        <div class="invalid-feedback" id="error-edit_harga"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_stok" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_stok" name="stok" min="0" required>
                        <div class="invalid-feedback" id="error-edit_stok"></div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="modalDetailProduk" tabindex="-1" role="dialog" aria-labelledby="modalDetailProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailProdukLabel">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Nama Produk</label>
                                <div id="detail_nama_produk" class="form-control-static bg-light p-2 rounded"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Harga</label>
                                <div id="detail_harga" class="form-control-static bg-light p-2 rounded"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <div id="detail_stok" class="form-control-static bg-light p-2 rounded"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <div id="detail_deskripsi" class="form-control-static bg-light p-2 rounded" style="min-height: 60px;"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Tanggal Ditambahkan</label>
                                <div id="detail_created_at" class="form-control-static bg-light p-2 rounded"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Terakhir Diupdate</label>
                                <div id="detail_updated_at" class="form-control-static bg-light p-2 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning btnEditFromDetail" id="btnEditFromDetail">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Page Specific Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    var table = $('#produkTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= BASE_URL ?>produk/getData",
            "type": "GET",
            "error": function(xhr, error, thrown) {
                console.error("Error DataTable: ", error, thrown);
                console.log("Response: ", xhr.responseText);
                
                // Notifikasi user
                toastr.error('Terjadi kesalahan saat memuat data. Silakan coba refresh halaman.');
                
                // Jika response bukan JSON
                if (typeof xhr.responseText === 'string' && xhr.responseText.indexOf('<!DOCTYPE') !== -1) {
                    console.error("Response bukan JSON, kemungkinan halaman error HTML");
                    // Reload halaman setelah 3 detik
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                }
            }
        },
        "columns": [
            { "data": 0 }, // ID
            { "data": 1 }, // Nama Produk
            { 
                "data": 2,
                "render": function(data, type, row) {
                    // Hapus karakter non-numerik (seperti "Rp", spasi, titik, dsb)
                    var hargaStr = String(data).replace(/[^0-9,-]/g, '').replace(',', '.');
                    // Default ke 0 jika tidak bisa di-parse
                    var harga = parseFloat(hargaStr) || 0;
                    return 'Rp ' + harga.toLocaleString('id-ID');
                }
            }, // Harga
            { "data": 3 }, // Stok
            { 
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    var html = '<button type="button" class="btn btn-sm btn-info btnDetail" data-id="' + row[0] + '">Detail</button> ';
                    html += '<button type="button" class="btn btn-sm btn-warning btnEdit" data-id="' + row[0] + '">Edit</button> ';
                    <?php if ($isAdmin): ?>
                    html += '<button type="button" class="btn btn-sm btn-danger btnHapus" data-id="' + row[0] + '">Hapus</button>';
                    <?php endif; ?>
                    return html;
                }
            }  // Aksi
        ],
        "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
    
    // Form Tambah Produk
    $('#formTambahProduk').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validasi
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            url: '<?= BASE_URL ?>produk/tambah',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tutup modal
                    $('#modalTambahProduk').modal('hide');
                    
                    // Reset form
                    $('#formTambahProduk')[0].reset();
                    
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Refresh tabel
                    table.ajax.reload();
                } else {
                    toastr.error(response.message);
                    
                    // Tampilkan error validasi jika ada
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).text(message);
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Form Edit Produk
    $('#formEditProduk').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validasi
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            url: '<?= BASE_URL ?>produk/edit/' + $('#edit_id').val(),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tutup modal
                    $('#modalEditProduk').modal('hide');
                    
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Refresh tabel
                    table.ajax.reload();
                } else {
                    toastr.error(response.message);
                    
                    // Tampilkan error validasi jika ada
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#edit_' + field).addClass('is-invalid');
                            $('#error-edit_' + field).text(message);
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    // Detail Produk
    $(document).on('click', '.btnDetail', function() {
        var id = $(this).data('id');
        
        // Tampilkan loading
        Swal.fire({
            title: 'Memuat...',
            html: 'Mengambil data produk',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= BASE_URL ?>produk/detail/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Tutup loading
                Swal.close();
                
                if (response.success) {
                    // Isi detail produk ke modal
                    var produk = response.data;
                    $('#detail_nama_produk').html(produk.nama_produk || '<span class="text-muted">Tidak ada data</span>');
                    
                    // Format harga dengan benar
                    var hargaStr = String(produk.harga).replace(/[^0-9,-]/g, '').replace(',', '.');
                    var harga = parseFloat(hargaStr) || 0;
                    $('#detail_harga').html('Rp ' + harga.toLocaleString('id-ID'));
                    
                    $('#detail_stok').html(produk.stok + ' unit');
                    
                    // Handle deskripsi kosong
                    if (produk.deskripsi && produk.deskripsi.trim() !== '') {
                        $('#detail_deskripsi').html(produk.deskripsi.replace(/\n/g, '<br>'));
                    } else {
                        $('#detail_deskripsi').html('<span class="text-muted">Tidak ada deskripsi</span>');
                    }
                    
                    // Format tanggal
                    $('#detail_created_at').html(produk.created_at || '<span class="text-muted">-</span>');
                    $('#detail_updated_at').html(produk.updated_at || '<span class="text-muted">-</span>');
                    
                    // Simpan ID untuk tombol edit
                    $('#btnEditFromDetail').data('id', produk.id);
                    
                    // Buka modal detail
                    $('#modalDetailProduk').modal('show');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Tutup loading
                Swal.close();
                toastr.error('Terjadi kesalahan saat mengambil detail produk.');
                console.error('Error:', error);
            }
        });
    });
    
    // Edit dari tombol detail
    $(document).on('click', '.btnEditFromDetail', function() {
        var id = $(this).data('id');
        
        // Tutup modal detail
        $('#modalDetailProduk').modal('hide');
        
        // Simulasi klik tombol edit
        $('.btnEdit[data-id="' + id + '"]').click();
    });
    
    <?php if ($isAdmin): ?>
    // Hapus Produk
    $(document).on('click', '.btnHapus', function() {
        var id = $(this).data('id');
        
        // Konfirmasi hapus
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data produk akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim request hapus
                $.ajax({
                    url: '<?= BASE_URL ?>produk/hapus',
                    type: 'POST',
                    data: {
                        id: id,
                        <?= CSRF_TOKEN_NAME ?>: $('input[name="<?= CSRF_TOKEN_NAME ?>"]').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            );
                            
                            // Refresh tabel
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
    <?php endif; ?>
    
    // Open Edit Modal with Data
    $(document).on('click', '.btnEdit', function() {
        var id = $(this).data('id');
        
        // Tampilkan loading
        Swal.fire({
            title: 'Memuat...',
            html: 'Mengambil data produk',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= BASE_URL ?>produk/detail/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Tutup loading
                Swal.close();
                
                if (response.success) {
                    var produk = response.data;
                    
                    // Isi form dengan data produk
                    $('#edit_id').val(produk.id);
                    $('#edit_nama_produk').val(produk.nama_produk);
                    $('#edit_harga').val(produk.harga);
                    $('#edit_stok').val(produk.stok);
                    $('#edit_deskripsi').val(produk.deskripsi);
                    
                    // Reset validasi
                    $('#formEditProduk .is-invalid').removeClass('is-invalid');
                    
                    // Buka modal edit
                    $('#modalEditProduk').modal('show');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Tutup loading
                Swal.close();
                toastr.error('Terjadi kesalahan saat mengambil data produk.');
                console.error('Error:', error);
            }
        });
    });
});
</script> 