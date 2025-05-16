<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
            <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
        </a>    
        <!-- Logo -->
        <?php
        // Tentukan URL dashboard berdasarkan role
        $dashboardUrl = BASE_URL . 'dashboard';
        ?>
        <a href="<?= $dashboardUrl ?>" class="logo">
          <!-- logo-->
          <div class="logo-lg">
              <span class="light-logo"><img src="<?= BASE_URL ?>template/images/logo-dark-text.png" alt="logo"></span>
              <span class="dark-logo"><img src="<?= BASE_URL ?>template/images/logo-light-text.png" alt="logo"></span>
          </div>
        </a>    
    </div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item d-md-none">
                    <a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
                        <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                    </a>
                </li>
            </ul> 
        </div>
        
        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">    
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen" title="Full Screen">
                        <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </li>
                
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="User">
                        <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                            <?php
                            // Tentukan URL profil berdasarkan role
                            $profilUrl = BASE_URL . 'profile';
                            ?>
                            <a class="dropdown-item" href="<?= $profilUrl ?>"><i class="ti-user text-muted me-2"></i> Profil</a>
                            <?php if ($this->session->get('user_role') === 'admin'): ?>
                            <a class="dropdown-item" href="<?= BASE_URL ?>pengaturan"><i class="ti-settings text-muted me-2"></i> Pengaturan Website</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= BASE_URL ?>auth/logout"><i class="ti-lock text-muted me-2"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header> 