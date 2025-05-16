<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Profile Controller
 * 
 * Controller untuk menangani profil pengguna
 */
class ProfileController extends Controller
{
    private $userModel;
    private $pengaturanModel;
    private $isAdmin = false;
    
    /**
     * Constructor
     * Load dependency dan cek akses
     */
    public function __construct()
    {
        // Panggil konstruktor parent terlebih dahulu
        parent::__construct();
        
        // Inisialisasi model
        $this->userModel = $this->model('User');
        $this->pengaturanModel = $this->model('Pengaturan');
        
        // Cek apakah user sudah login
        if (!$this->session->has('user_id')) {
            Helper::redirect('auth');
            exit;
        }
        
        // Periksa jika user adalah admin
        $this->isAdmin = ($this->session->get('user_role') === 'admin');
    }
    
    /**
     * Mengambil data pengaturan website untuk layout
     * 
     * @return array
     */
    private function getPengaturanData()
    {
        // Ambil data pengaturan dari database
        $pengaturan = $this->pengaturanModel->getAllPengaturan();
        
        // Default pengaturan jika belum ada di database
        $defaultPengaturan = [
            'nama_situs' => APP_NAME,
            'tagline' => $this->isAdmin ? 'Administrator Panel' : 'User Panel',
            'logo_path' => 'assets/images/logo.png',
            'favicon_path' => 'assets/images/favicon.ico',
        ];
        
        // Gabungkan default dengan pengaturan dari database
        return array_merge($defaultPengaturan, $pengaturan);
    }
    
    /**
     * Halaman profil user
     * 
     * @return void
     */
    public function index()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->getUserById($userId);
        
        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'isAdmin' => $this->isAdmin,
            'pengaturan' => $this->getPengaturanData()
        ];
        
        $this->renderWithSharedLayout('profil/index', $data);
    }
    
    /**
     * Update profil via AJAX
     * 
     * @return void
     */
    public function update()
    {
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('profile');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        $userId = $this->session->get('user_id');
        $user = $this->userModel->getUserById($userId);
        
        // Sanitize input
        $nama = Helper::sanitize($_POST['nama'] ?? '');
        $email = Helper::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validasi input
        $validation_data = [
            'nama' => $nama,
            'email' => $email
        ];
        
        $validation_rules = [
            'nama' => 'required',
            'email' => 'required|email'
        ];
        
        if (!empty($password)) {
            $validation_data['password'] = $password;
            $validation_data['confirm_password'] = $confirm_password;
            $validation_rules['password'] = 'min:6';
            $validation_rules['confirm_password'] = 'required|match:password';
        }
        
        $errors = $this->validate($validation_data, $validation_rules);
        
        // Cek apakah email sudah terdaftar oleh pengguna lain
        if (empty($errors['email']) && $email !== $user['email'] && $this->userModel->emailExists($email)) {
            $errors['email'] = 'Email sudah digunakan oleh pengguna lain';
        }
        
        if (empty($errors)) {
            $userData = [
                'id' => $userId,
                'nama' => $nama,
                'email' => $email
            ];
            
            if (!empty($password)) {
                $userData['password'] = $password;
            }
            
            if ($this->userModel->update($userData)) {
                // Update session data
                $this->session->set('user_name', $nama);
                $this->session->set('user_email', $email);
                
                $this->json(['success' => true, 'message' => 'Profil berhasil diperbarui']);
            } else {
                $this->json(['success' => false, 'message' => 'Gagal memperbarui profil'], 500);
            }
        } else {
            $this->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $errors], 400);
        }
    }
    
    /**
     * Mendapatkan token CSRF baru untuk form AJAX
     *
     * @return void
     */
    public function getNewCsrfToken()
    {
        if (!Helper::isAjax()) {
            $this->redirect('profile');
            return;
        }
        
        $csrf = new \core\CSRF();
        $token = $csrf->regenerateToken();
        
        $this->json([
            'success' => true,
            'token' => $token
        ]);
    }
} 