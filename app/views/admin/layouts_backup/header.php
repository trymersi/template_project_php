<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= APP_NAME ?> - Admin Dashboard">
    <meta name="author" content="<?= APP_NAME ?>">
    <link rel="icon" href="<?= BASE_URL ?>assets/images/favicon.ico">

    <title><?= $title ?? APP_NAME ?> - Admin</title>
    
    <!-- Vendors Style-->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/vendors_css.css">
      
    <!-- Style-->  
    <link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/skin_color.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
    
<div class="wrapper">
    <div id="loader"></div>
    
    <header class="main-header">
        <div class="d-flex align-items-center logo-box justify-content-start">
            <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
                <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            </a>    
            <!-- Logo -->
            <a href="<?= BASE_URL ?>admin/dashboard" class="logo">
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
                                <a class="dropdown-item" href="<?= BASE_URL ?>admin/profil"><i class="ti-user text-muted me-2"></i> Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= BASE_URL ?>auth/logout"><i class="ti-lock text-muted me-2"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <aside class="main-sidebar">
        <!-- sidebar-->
        <section class="sidebar position-relative">    
            <div class="multinav">
                <div class="multinav-scroll" style="height: 100%;">    
                    <!-- sidebar menu-->
                    <ul class="sidebar-menu" data-widget="tree">    
                        <li class="header">Dashboard & Menu</li>
                        <li class="<?= $this->getActiveMenu('dashboard') ?>">
                            <a href="<?= BASE_URL ?>admin/dashboard">
                                <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="header">Manajemen</li>
                        <li class="treeview <?= $this->getActiveMenu('produk') ?>">
                            <a href="#">
                                <i class="icon-Box2"><span class="path1"></span><span class="path2"></span></i>
                                <span>Produk</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= BASE_URL ?>admin/produk"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Daftar Produk</a></li>
                                <li><a href="<?= BASE_URL ?>admin/produk/tambah"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Tambah Produk</a></li>
                            </ul>
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
                        
                        <li class="header">Akun</li>
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
            <a href="<?= BASE_URL ?>admin/profil" class="link" data-bs-toggle="tooltip" title="Profil"><i class="ti-user"></i></a>
            <a href="<?= BASE_URL ?>admin/pengaturan" class="link" data-bs-toggle="tooltip" title="Pengaturan"><i class="ti-settings"></i></a>
            <a href="<?= BASE_URL ?>auth/logout" class="link" data-bs-toggle="tooltip" title="Logout"><i class="ti-lock"></i></a>
        </div>
    </aside>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <!-- Flash Messages -->
                <?php if ($this->session->hasFlash('success')): ?>
                    <div class="alert alert-success-light alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="alert-icon">
                                <span class="icon-Approved-window"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                            </div>
                            <div class="ms-10">
                                <?= $this->session->getFlash('success') ?>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->hasFlash('error')): ?>
                    <div class="alert alert-danger-light alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="alert-icon">
                                <span class="icon-Caution-sign"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                            </div>
                            <div class="ms-10">
                                <?= $this->session->getFlash('error') ?>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            
 
