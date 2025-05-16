<?php
/**
 * File Konfigurasi Utama
 * Berisi konstanta dan pengaturan untuk aplikasi
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'template_project_php');

// Konfigurasi URL
define('BASE_URL', 'http://localhost/template_project_php/');

// Konfigurasi App
define('APP_NAME', 'Sistem Inventory');
define('APP_VERSION', '1.0.0');

// Konfigurasi Path
define('ROOT_PATH', dirname(dirname(__DIR__)) . '/');
define('APP_PATH', ROOT_PATH . 'app/');
define('VIEW_PATH', APP_PATH . 'views/');
define('ASSET_PATH', BASE_URL . 'assets/');

// Konfigurasi Session
define('SESSION_LIFETIME', 3600); // 1 jam dalam detik
define('SESSION_NAME', 'inventory_session');

// Konfigurasi CSRF Token
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_TOKEN_LENGTH', 32);

// Timezone
date_default_timezone_set('Asia/Jakarta'); 