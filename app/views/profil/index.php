<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title"><?= $isAdmin ? 'Profil Admin' : 'Profil Saya' ?></h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>dashboard">
                                <i class="mdi mdi-home-outline"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
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
                <h4 class="box-title">Informasi Profil</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <form id="formProfil" method="post">
                            <!-- CSRF Token -->
                            <?php $csrf = new \core\CSRF(); ?>
                            <?= $csrf->getTokenField() ?>
                            
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama'] ?>" required>
                                <div class="invalid-feedback" id="error-nama"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                                <div class="invalid-feedback" id="error-email"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="invalid-feedback" id="error-password"></div>
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                <div class="invalid-feedback" id="error-confirm_password"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label">Tanggal Bergabung</label>
                                <div class="form-control-plaintext"><?= (new \core\Helper)->formatDate($user['created_at']) ?></div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Profil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Specific Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mendapatkan CSRF token baru
    function refreshCsrfToken() {
        $.ajax({
            url: '<?= BASE_URL ?>profile/getNewCsrfToken',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('input[name="<?= CSRF_TOKEN_NAME ?>"]').val(response.token);
                }
            }
        });
    }

    // Update Profil Form
    $('#formProfil').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validasi
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        $.ajax({
            url: '<?= BASE_URL ?>profile/update',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                    
                    // Reset password fields
                    $('#password, #confirm_password').val('');
                    
                    // Refresh CSRF token
                    refreshCsrfToken();
                } else {
                    // Tampilkan pesan error umum jika ada
                    if (response.message) {
                        toastr.error(response.message);
                    }
                    
                    // Tampilkan error validasi jika ada
                    if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).text(message);
                        });
                    }
                    
                    // Refresh CSRF token
                    refreshCsrfToken();
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
                
                // Refresh CSRF token
                refreshCsrfToken();
            }
        });
    });
});
</script> 