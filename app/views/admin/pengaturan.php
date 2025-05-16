<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Pengaturan Website</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
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
                    </div>

                    <div class="form-group mb-3">
                        <label for="tagline" class="form-label">Tagline</label>
                        <input type="text" class="form-control" id="tagline" name="tagline" value="<?= $pengaturan['tagline'] ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Website</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $pengaturan['deskripsi'] ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email_admin" class="form-label">Email Admin</label>
                        <input type="email" class="form-control" id="email_admin" name="email_admin" value="<?= $pengaturan['email_admin'] ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= $pengaturan['alamat'] ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $pengaturan['telepon'] ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="footer_text" class="form-label">Teks Footer</label>
                        <input type="text" class="form-control" id="footer_text" name="footer_text" value="<?= $pengaturan['footer_text'] ?>">
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
                                <img src="<?= BASE_URL . $pengaturan['logo_path'] ?>" alt="Logo Saat Ini" class="img-fluid" style="max-height: 80px;">
                                <div class="mt-2"><small class="text-muted">Logo Saat Ini</small></div>
                            </div>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpeg, image/gif">
                            <small class="form-text text-muted">Format yang diizinkan: PNG, JPG, GIF. Ukuran maksimum: 2MB.</small>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="favicon" class="form-label">Favicon</label>
                        <div class="d-flex flex-column">
                            <div class="mb-3 p-3 bg-light text-center">
                                <img src="<?= BASE_URL . $pengaturan['favicon_path'] ?>" alt="Favicon Saat Ini" class="img-fluid" style="max-height: 32px;">
                                <div class="mt-2"><small class="text-muted">Favicon Saat Ini</small></div>
                            </div>
                            <input type="file" class="form-control" id="favicon" name="favicon" accept="image/x-icon, image/png">
                            <small class="form-text text-muted">Disarankan format ICO atau PNG dengan ukuran 16x16, 32x32, atau 64x64 pixel.</small>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Logo & Favicon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Tampilan Website</h4>
            </div>
            <div class="box-body">
                <form id="formTampilan" method="post">
                    <!-- CSRF Token -->
                    <?= $csrf->getTokenField() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tema_utama" class="form-label">Tema Utama</label>
                                <select class="form-select" id="tema_utama" name="tema_utama">
                                    <option value="light" selected>Light Mode</option>
                                    <option value="dark">Dark Mode</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="warna_tema" class="form-label">Warna Tema</label>
                                <select class="form-select" id="warna_tema" name="warna_tema">
                                    <option value="primary" selected>Primary (Biru)</option>
                                    <option value="success">Success (Hijau)</option>
                                    <option value="danger">Danger (Merah)</option>
                                    <option value="warning">Warning (Kuning)</option>
                                    <option value="info">Info (Cyan)</option>
                                    <option value="purple">Purple</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="layout_sidebar" class="form-label">Layout Sidebar</label>
                                <select class="form-select" id="layout_sidebar" name="layout_sidebar">
                                    <option value="fixed" selected>Fixed</option>
                                    <option value="mini">Mini Sidebar</option>
                                    <option value="collapsed">Collapsed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="header_style" class="form-label">Style Header</label>
                                <select class="form-select" id="header_style" name="header_style">
                                    <option value="fixed" selected>Fixed</option>
                                    <option value="static">Static</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_animation" name="enable_animation" checked>
                            <label class="form-check-label" for="enable_animation">Aktifkan Animasi UI</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan Tampilan</button>
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
        
        // Simulasi proses simpan data
        toastr.info('Menyimpan pengaturan website...');
        setTimeout(function() {
            toastr.success('Pengaturan website berhasil disimpan');
        }, 1000);
    });
    
    // Form Logo & Favicon
    $('#formLogoFavicon').on('submit', function(e) {
        e.preventDefault();
        
        // Validasi file yang diupload
        const logoFile = $('#logo')[0].files[0];
        const faviconFile = $('#favicon')[0].files[0];
        
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        if (logoFile && logoFile.size > maxSize) {
            toastr.error('Ukuran logo terlalu besar, maksimum 2MB');
            return;
        }
        
        if (faviconFile && faviconFile.size > maxSize) {
            toastr.error('Ukuran favicon terlalu besar, maksimum 2MB');
            return;
        }
        
        // Simulasi proses upload
        if (logoFile || faviconFile) {
            toastr.info('Mengupload file...');
            
            setTimeout(function() {
                toastr.success('Logo dan favicon berhasil diperbarui');
            }, 1500);
        } else {
            toastr.error('Tidak ada file yang dipilih');
        }
    });
    
    // Form Tampilan Website
    $('#formTampilan').on('submit', function(e) {
        e.preventDefault();
        
        const tema = $('#tema_utama').val();
        const warna = $('#warna_tema').val();
        
        // Simulasi perubahan tema
        toastr.info('Menyimpan pengaturan tampilan...');
        
        setTimeout(function() {
            toastr.success('Pengaturan tampilan berhasil disimpan');
            
            // Contoh implementasi: menampilkan preview perubahan tema
            console.log(`Tema diubah ke: ${tema} dengan warna ${warna}`);
        }, 1000);
    });
});
</script> 