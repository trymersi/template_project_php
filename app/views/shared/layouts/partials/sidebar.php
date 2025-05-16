<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">    
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">    
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">    
                    <li class="header">Dashboard & Menu</li>
                    <?php
                    // Tentukan URL dashboard berdasarkan role
                    $dashboardUrl = BASE_URL . 'dashboard';
                    ?>
                    <li class="<?= $this->getActiveMenu('dashboard') ?>">
                        <a href="<?= $dashboardUrl ?>">
                            <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <?php if ($this->session->get('user_role') === 'admin'): ?>
                    <!-- Menu Khusus Admin -->
                    <li class="header">Manajemen</li>
                    <li class="<?= $this->getActiveMenu('produk') ?>">
                        <a href="<?= BASE_URL ?>produk">
                            <i class="icon-Box2"><span class="path1"></span><span class="path2"></span></i>
                            <span>Produk</span>
                        </a>
                    </li>
                    
                    <li class="treeview <?= $this->getActiveMenu('user') ?>">
                        <a href="#">
                            <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                            <span>Pengguna</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= BASE_URL ?>admin/user"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Daftar Pengguna</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <!-- Menu Khusus User -->
                    <li class="header">Produk</li>
                    <li class="<?= $this->getActiveMenu('produk') ?>">
                        <a href="<?= BASE_URL ?>produk">
                            <i class="icon-Box2"><span class="path1"></span><span class="path2"></span></i>
                            <span>Daftar Produk</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="header">Akun</li>
                    <?php
                    // Tentukan URL profil berdasarkan role
                    $profilUrl = BASE_URL . 'profile';
                    ?>
                    <li class="<?= $this->getActiveMenu('profil') ?>">
                        <a href="<?= $profilUrl ?>">
                            <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <?php if ($this->session->get('user_role') === 'admin'): ?>
                    <li class="<?= $this->getActiveMenu('pengaturan') ?>">
                        <a href="<?= BASE_URL ?>pengaturan">
                            <i class="icon-Settings-1"><span class="path1"></span><span class="path2"></span></i>
                            <span>Pengaturan Website</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= BASE_URL ?>auth/logout">
                            <i class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="sidebar-footer">
        <a href="<?= $profilUrl ?>" class="link" data-bs-toggle="tooltip" title="Profil"><i class="ti-user"></i></a>
        <?php if ($this->session->get('user_role') === 'admin'): ?>
        <a href="<?= BASE_URL ?>pengaturan" class="link" data-bs-toggle="tooltip" title="Pengaturan Website"><i class="ti-settings"></i></a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>auth/logout" class="link" data-bs-toggle="tooltip" title="Logout"><i class="ti-lock"></i></a>
    </div>
</aside> 