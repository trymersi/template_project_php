<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? $pengaturan['nama_situs'] ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= BASE_URL . $pengaturan['favicon_path'] ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            min-height: 100vh;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            max-width: 450px;
            width: 90%;
            padding: 15px;
        }
        
        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: none;
            text-align: center;
            padding: 2rem 2rem 1rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .app-logo {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            font-size: 2.5rem;
        }
        
        .app-name {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .app-description {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-floating > .form-control {
            padding: 1rem 0.75rem;
        }
        
        .form-floating > label {
            padding: 1rem 0.75rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .register-link {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <div class="app-logo">
                    <?php if (file_exists($pengaturan['logo_path']) && !is_dir($pengaturan['logo_path'])): ?>
                        <img src="<?= BASE_URL . $pengaturan['logo_path'] ?>" alt="Logo" class="img-fluid" style="max-height: 50px;">
                    <?php else: ?>
                        <i class="bi bi-box-seam"></i>
                    <?php endif; ?>
                </div>
                <h1 class="app-name"><?= $pengaturan['nama_situs'] ?></h1>
                <p class="app-description"><?= $pengaturan['tagline'] ?></p>
            </div>
            <div class="card-body">
                <?php if ($this->session->hasFlash('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= $this->session->getFlash('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= $this->session->getFlash('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form action="<?= BASE_URL ?>auth/login" method="post">
                    <!-- CSRF Token -->
                    <?php $csrf = new \core\CSRF(); ?>
                    <?= $csrf->getTokenField() ?>
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $email ?? '' ?>" placeholder="name@example.com" required>
                        <label for="email">Email</label>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </div>
                    
                    <div class="register-link">
                        <p>Belum punya akun? <a href="<?= BASE_URL ?>auth/register">Daftar Sekarang</a></p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <p class="small text-white">
                &copy; <?= date('Y') ?> <?= $pengaturan['nama_situs'] ?> v<?= APP_VERSION ?>
            </p>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto close alert after 5 seconds
        window.setTimeout(function() {
            document.querySelectorAll(".alert").forEach(function(alert) {
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html> 