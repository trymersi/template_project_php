<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Pengaturan Website</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>dashboard"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Pengaturan Umum Website</h4>
            </div>
            <div class="box-body">
                <form id="formPengaturanUmum" method="post">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>

                    <div class="form-group mb-3">
                        <label for="nama_situs" class="form-label">Nama Website</label>
                        <input type="text" class="form-control" id="nama_situs" name="nama_situs" value="<?= $pengaturan['nama_situs'] ?>" required>
                        <div class="invalid-feedback" id="error-nama_situs"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tagline" class="form-label">Tagline</label>
                        <input type="text" class="form-control" id="tagline" name="tagline" value="<?= $pengaturan['tagline'] ?>">
                        <div class="invalid-feedback" id="error-tagline"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Website</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $pengaturan['deskripsi'] ?></textarea>
                        <div class="invalid-feedback" id="error-deskripsi"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email_admin" class="form-label">Email Admin</label>
                        <input type="email" class="form-control" id="email_admin" name="email_admin" value="<?= $pengaturan['email_admin'] ?>">
                        <div class="invalid-feedback" id="error-email_admin"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= $pengaturan['alamat'] ?></textarea>
                        <div class="invalid-feedback" id="error-alamat"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $pengaturan['telepon'] ?>">
                        <div class="invalid-feedback" id="error-telepon"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="footer_text" class="form-label">Teks Footer</label>
                        <input type="text" class="form-control" id="footer_text" name="footer_text" value="<?= $pengaturan['footer_text'] ?>">
                        <div class="invalid-feedback" id="error-footer_text"></div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Logo & Favicon</h4>
            </div>
            <div class="box-body">
                <form id="formLogoFavicon" method="post" enctype="multipart/form-data">
                    <!-- CSRF Token -->
                    <?= $csrf->getTokenField() ?>

                    <div class="form-group mb-4">
                        <label for="logo" class="form-label">Logo Website</label>
                        <div class="d-flex flex-column">
                            <div class="mb-3 p-3 bg-light text-center">
                                <img src="<?= BASE_URL . $pengaturan['logo_path'] ?>" alt="Logo Saat Ini" class="img-fluid" style="max-height: 80px;" id="logoPreview">
                                <div class="mt-2"><small class="text-muted">Logo Saat Ini</small></div>
                            </div>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg, image/gif">
                            <small class="form-text text-muted">Format yang diizinkan: PNG, JPG, GIF. Ukuran maksimum: 2MB.</small>
                            <div class="invalid-feedback" id="error-logo"></div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="favicon" class="form-label">Favicon</label>
                        <div class="d-flex flex-column">
                            <div class="mb-3 p-3 bg-light text-center">
                                <img src="<?= BASE_URL . $pengaturan['favicon_path'] ?>" alt="Favicon Saat Ini" class="img-fluid" style="max-height: 32px;" id="faviconPreview">
                                <div class="mt-2"><small class="text-muted">Favicon Saat Ini</small></div>
                            </div>
                            <input type="file" class="form-control" id="favicon" name="favicon" accept="image/x-icon, image/png">
                            <small class="form-text text-muted">Disarankan format ICO atau PNG dengan ukuran 16x16, 32x32, atau 64x64 pixel.</small>
                            <div class="invalid-feedback" id="error-favicon"></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Logo & Favicon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Page Specific Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Pengaturan Umum Website
    $('#formPengaturanUmum').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validasi
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        // Tampilkan loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= BASE_URL ?>pengaturan/simpanPengaturanUmum',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                    
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
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan pengaturan'
                });
                console.error(xhr.responseText);
            }
        });
    });
    
    // Form Logo & Favicon
    $('#formLogoFavicon').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validasi
        $(this).find('.is-invalid').removeClass('is-invalid');
        
        // Validasi file yang diupload
        const logoFile = $('#logo')[0].files[0];
        const faviconFile = $('#favicon')[0].files[0];
        
        // Cek apakah ada file yang dipilih
        if (!logoFile && !faviconFile) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih minimal satu file untuk diupload'
            });
            return;
        }
        
        // Form data untuk upload file
        var formData = new FormData(this);
        
        // Tampilkan loading
        Swal.fire({
            title: 'Mengupload...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= BASE_URL ?>pengaturan/simpanLogoFavicon',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.close();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    // Reset form
                    $('#formLogoFavicon')[0].reset();
                    
                    // Reload halaman setelah berhasil upload untuk melihat perubahan
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengupload file'
                });
                console.error(xhr.responseText);
            }
        });
    });
    
    // Preview Logo
    $('#logo').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Preview Favicon
    $('#favicon').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#faviconPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script> 