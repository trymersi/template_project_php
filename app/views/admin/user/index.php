<!-- Custom CSS untuk memperbaiki horizontal scroll -->
<style>
    /* Perbaikan horizontal scroll */
    .dataTables_wrapper {
        width: 100%;
        overflow-x: hidden;
    }
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Manajemen Pengguna</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Pengguna</li>
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
                <h4 class="box-title">Daftar Pengguna</h4>
                <div class="box-controls pull-right">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="ti-plus me-5"></i> Tambah Pengguna
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
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

<!-- Modal Tambah User -->
<div class="modal center-modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahUser" method="post">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
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

<!-- Modal Edit User -->
<div class="modal center-modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditUserLabel">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" method="post">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group mb-3">
                        <label for="edit_nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
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
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fs-60 text-warning icon-Question"></i>
                    <h4 class="mt-15 mb-15">Apakah Anda yakin ingin menghapus pengguna ini?</h4>
                </div>
            </div>
            <div class="modal-footer modal-footer-uniform">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="<?= BASE_URL ?>admin/hapusUser" method="post">
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
    
    // Initialize DataTable
    var userTable = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= BASE_URL ?>admin/getUserData',
            type: 'GET'
        },
        columns: [
            { data: 0 }, // ID
            { data: 1 }, // Nama
            { data: 2 }, // Email
            { data: 3 }, // Role
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
    
    // Tambah User Form Submission
    $('#formTambahUser').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= BASE_URL ?>admin/tambahUser',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Reset form
                    $('#formTambahUser').trigger('reset');
                    
                    // Tutup modal
                    cleanupModal('#modalTambahUser');
                    
                    // Refresh DataTable
                    userTable.ajax.reload();
                    
                    // Refresh CSRF Token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error
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
    $('#userTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var email = $(this).data('email');
        var role = $(this).data('role');
        
        $('#edit_id').val(id);
        $('#edit_nama').val(nama);
        $('#edit_email').val(email);
        $('#edit_role').val(role);
        
        $('#modalEditUser').modal('show');
    });
    
    // Edit User Form Submission
    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= BASE_URL ?>admin/editUser',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Reset form
                    $('#formEditUser').trigger('reset');
                    
                    // Tutup modal
                    cleanupModal('#modalEditUser');
                    
                    // Refresh DataTable
                    userTable.ajax.reload();
                    
                    // Refresh CSRF Token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error
                    toastr.error(response.message);
                    
                    // Tampilkan error validasi jika ada
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#edit_' + field).addClass('is-invalid');
                            $('#edit_error-' + field).text(message);
                        });
                    }
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
    $('#userTable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#deleteModal').modal('show');
    });
    
    // Delete User Form Submission
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
                    userTable.ajax.reload();
                    
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