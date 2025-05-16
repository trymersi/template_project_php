<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Auth Controller
 * 
 * Controller untuk menangani autentikasi (login, logout, register)
 */
class AuthController extends Controller
{
    private $userModel;
    
    /**
     * Constructor
     * Load model User
     */
    public function __construct()
    {
        // Panggil konstruktor parent terlebih dahulu
        parent::__construct();
        
        // Inisialisasi model
        $this->userModel = $this->model('User');
    }
    
    /**
     * Halaman login
     * 
     * @return void
     */
    public function index()
    {
        // Redirect ke dashboard jika sudah login
        if ($this->session->has('user_id')) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Login',
            'errors' => []
        ];
        
        $this->view('shared/auth/login', $data);
    }
    
    /**
     * Proses login
     * 
     * @return void
     */
    public function login()
    {
        // Redirect ke dashboard jika sudah login
        if ($this->session->has('user_id')) {
            $this->redirect('dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth');
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->session->setFlash('error', 'CSRF token tidak valid');
            $this->redirect('auth');
        }
        
        // Sanitize input
        $email = Helper::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validasi input
        $errors = $this->validate(
            ['email' => $email, 'password' => $password],
            ['email' => 'required|email', 'password' => 'required']
        );
        
        if (!empty($errors)) {
            $data = [
                'title' => 'Login',
                'errors' => $errors,
                'email' => $email
            ];
            
            $this->view('shared/auth/login', $data);
            return;
        }
        
        // Cek login
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            // Set session
            $this->session->set('user_id', $user['id']);
            $this->session->set('user_name', $user['nama']);
            $this->session->set('user_email', $user['email']);
            $this->session->set('user_role', $user['role']);
            $this->session->regenerate();
            
            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('user/dashboard');
            }
        } else {
            $this->session->setFlash('error', 'Email atau password salah');
            
            $data = [
                'title' => 'Login',
                'errors' => [],
                'email' => $email
            ];
            
            $this->view('shared/auth/login', $data);
        }
    }
    
    /**
     * Halaman register
     * 
     * @return void
     */
    public function register()
    {
        // Redirect ke dashboard jika sudah login
        if ($this->session->has('user_id')) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Register',
            'errors' => []
        ];
        
        $this->view('shared/auth/register', $data);
    }
    
    /**
     * Proses register
     * 
     * @return void
     */
    public function doRegister()
    {
        // Redirect ke dashboard jika sudah login
        if ($this->session->has('user_id')) {
            $this->redirect('dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->session->setFlash('error', 'CSRF token tidak valid');
            $this->redirect('auth/register');
        }
        
        // Sanitize input
        $nama = Helper::sanitize($_POST['nama'] ?? '');
        $email = Helper::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validasi input
        $errors = $this->validate(
            [
                'nama' => $nama,
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ],
            [
                'nama' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|match:password'
            ]
        );
        
        // Cek apakah email sudah terdaftar
        if (empty($errors['email']) && $this->userModel->emailExists($email)) {
            $errors['email'] = 'Email sudah terdaftar';
        }
        
        if (!empty($errors)) {
            $data = [
                'title' => 'Register',
                'errors' => $errors,
                'nama' => $nama,
                'email' => $email
            ];
            
            $this->view('shared/auth/register', $data);
            return;
        }
        
        // Register user baru
        $userData = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => 'user'
        ];
        
        if ($this->userModel->register($userData)) {
            $this->session->setFlash('success', 'Registrasi berhasil, silahkan login');
            $this->redirect('auth');
        } else {
            $this->session->setFlash('error', 'Registrasi gagal, silahkan coba lagi');
            
            $data = [
                'title' => 'Register',
                'errors' => [],
                'nama' => $nama,
                'email' => $email
            ];
            
            $this->view('shared/auth/register', $data);
        }
    }
    
    /**
     * Logout
     * 
     * @return void
     */
    public function logout()
    {
        // Hapus semua session
        $this->session->destroy();
        
        // Redirect ke halaman login
        $this->redirect('auth');
    }

    /**
     * Reset password admin (hanya dapat diakses secara langsung)
     * 
     * @return void
     */
    public function resetAdminPassword()
    {
        // Koneksi database langsung
        $db = new \core\Database();
        
        // Generate password hash baru untuk 'password'
        $newHash = password_hash('password', PASSWORD_DEFAULT);
        
        // Update password admin
        $db->query('UPDATE users SET password = :password WHERE email = :email');
        $db->bind(':password', $newHash);
        $db->bind(':email', 'admin@admin.com');
        
        if ($db->execute()) {
            echo "Password admin berhasil diperbarui. Hash baru: " . $newHash;
        } else {
            echo "Gagal memperbarui password admin.";
        }
        exit;
    }
} 