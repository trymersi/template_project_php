<?php
namespace core;

/**
 * Base Controller 
 * 
 * Class induk untuk semua controller dalam aplikasi.
 * Berisi method umum seperti load model dan view.
 */
class Controller
{
    // Tambahkan properti session yang bisa diakses dari view
    public $session;
    
    /**
     * Constructor
     * Inisialisasi session
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * Load model
     * 
     * @param string $model Nama model yang akan di-load
     * @return object Instance dari model
     */
    public function model($model)
    {
        $modelClass = '\\models\\' . $model;
        return new $modelClass();
    }

    /**
     * Load view
     * 
     * @param string $view Nama file view yang akan di-load
     * @param array $data Data yang akan dikirim ke view
     * @return void
     */
    public function view($view, $data = [])
    {
        // Ekstrak data sehingga menjadi variabel
        if (!empty($data) && is_array($data)) {
            extract($data);
        }
        
        // Generate CSRF token jika belum ada
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $csrf = new CSRF();
            $csrf_token = $csrf->generateToken();
        } else {
            $csrf_token = $_SESSION[CSRF_TOKEN_NAME];
        }
        
        // Load view file
        $viewFile = VIEW_PATH . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('View tidak ditemukan: ' . $view);
        }
    }
    
    /**
     * Render view dengan layout bersama
     * 
     * @param string $view Path ke view
     * @param array $data Data yang akan dikirimkan ke view
     * @return void
     */
    protected function renderWithSharedLayout($view, $data = [])
    {
        // Set data untuk layout
        extract($data);
        
        // Render layout header
        require_once VIEW_PATH . 'shared/layouts/header.php';
        
        // Render view konten
        require_once VIEW_PATH . $view . '.php';
        
        // Render layout footer
        require_once VIEW_PATH . 'shared/layouts/footer.php';
    }
    
    /**
     * Redirect ke URL tertentu
     * 
     * @param string $url URL tujuan redirect
     * @return void
     */
    public function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Validasi input
     * 
     * @param array $data Data yang akan divalidasi
     * @param array $rules Aturan validasi
     * @return array Array berisi error (jika ada)
     */
    public function validate($data, $rules)
    {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $fieldRules = explode('|', $rule);
            
            foreach ($fieldRules as $fieldRule) {
                // Cek apakah rule memiliki parameter
                if (strpos($fieldRule, ':') !== false) {
                    list($ruleName, $ruleParam) = explode(':', $fieldRule);
                } else {
                    $ruleName = $fieldRule;
                    $ruleParam = null;
                }
                
                // Required validation
                if ($ruleName === 'required' && (!isset($data[$field]) || trim($data[$field]) === '')) {
                    $errors[$field] = ucfirst($field) . ' wajib diisi';
                    break;
                }
                
                // Skip validasi lain jika field kosong dan tidak wajib
                if (!isset($data[$field]) || $data[$field] === '') {
                    continue;
                }
                
                // Email validation
                if ($ruleName === 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Format email tidak valid';
                }
                
                // Min length validation
                if ($ruleName === 'min' && strlen($data[$field]) < $ruleParam) {
                    $errors[$field] = ucfirst($field) . ' minimal ' . $ruleParam . ' karakter';
                }
                
                // Max length validation
                if ($ruleName === 'max' && strlen($data[$field]) > $ruleParam) {
                    $errors[$field] = ucfirst($field) . ' maksimal ' . $ruleParam . ' karakter';
                }
                
                // Numeric validation
                if ($ruleName === 'numeric' && !is_numeric($data[$field])) {
                    $errors[$field] = ucfirst($field) . ' harus berupa angka';
                }
                
                // Match validation
                if ($ruleName === 'match' && isset($data[$ruleParam]) && $data[$field] !== $data[$ruleParam]) {
                    $errors[$field] = ucfirst($field) . ' tidak cocok dengan ' . $ruleParam;
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Verifikasi CSRF token
     * 
     * @return bool True jika token valid, false jika tidak
     */
    public function verifyCsrfToken()
    {
        $csrf = new CSRF();
        return $csrf->verifyToken();
    }
    
    /**
     * Response JSON
     * 
     * @param array $data Data yang akan dikirim sebagai JSON
     * @param int $status HTTP status code
     * @return void
     */
    public function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
    
    /**
     * Get active menu class
     * 
     * @param string $menu Nama menu yang akan dicek
     * @return string Class active jika menu aktif
     */
    public function getActiveMenu($menu)
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        $baseUrl = parse_url(BASE_URL, PHP_URL_PATH);
        
        // Hapus base URL dari current URL
        $currentUrl = str_replace($baseUrl, '', $currentUrl);
        
        // Ambil segment pertama
        $segments = explode('/', trim($currentUrl, '/'));
        $currentMenu = $segments[1] ?? '';
        
        return ($currentMenu === $menu) ? 'active' : '';
    }
} 