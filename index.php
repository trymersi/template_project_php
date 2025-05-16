<?php
/**
 * Entry Point utama aplikasi
 * File ini akan memuat Core aplikasi dan menjalankan Router
 */

// Muat konfigurasi
require_once 'app/config/config.php';

// Autoload Class
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = "app/{$class}.php";
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Muat Core Framework
require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';
require_once 'app/core/Session.php';
require_once 'app/core/CSRF.php';
require_once 'app/core/Helper.php';

// Inisialisasi Session
$session = new core\Session();

// Inisialisasi CSRF Protection
$csrf = new core\CSRF();

// Jalankan aplikasi
$app = new core\App(); 