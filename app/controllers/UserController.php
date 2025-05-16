<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * User Controller
 * 
 * Controller untuk halaman user
 */
class UserController extends Controller
{
    private $userModel;
    private $produkModel;
    
    /**
     * Constructor
     * Load dependency dan cek akses user
     */
    public function __construct()
    {
        // Panggil konstruktor parent terlebih dahulu
        parent::__construct();
        
        // Inisialisasi model
        $this->userModel = $this->model('User');
        $this->produkModel = $this->model('Produk');
        
        // Cek apakah user sudah login
        if (!$this->session->has('user_id')) {
            Helper::redirect('auth');
            exit;
        }
    }
    
    /**
     * Halaman dashboard user
     * 
     * @return void
     */
    public function dashboard()
    {
        $totalProduk = $this->produkModel->countProduk();
        $produkTerbaru = $this->produkModel->getProdukTerbaru(5);
        $chartData = $this->produkModel->getProdukForChart(5);
        
        $data = [
            'title' => 'Dashboard User',
            'totalProduk' => $totalProduk,
            'produkTerbaru' => $produkTerbaru,
            'chartData' => $chartData
        ];
        
        $this->renderWithSharedLayout('user/dashboard', $data);
    }
    
    /**
     * Metode index - redirect ke dashboard
     * 
     * @return void
     */
    public function index()
    {
        $this->redirect('user/dashboard');
    }
    
    /**
     * Lihat produk
     * 
     * @return void
     */
    public function produk()
    {
        $data = [
            'title' => 'Daftar Produk'
        ];
        
        $this->renderWithSharedLayout('user/produk/index', $data);
    }
    
    /**
     * Get data untuk DataTables produk
     * 
     * @return void
     */
    public function getProdukData()
    {
        if (!Helper::isAjax()) {
            $this->redirect('user/produk');
            return;
        }
        
        $params = $_GET;
        $data = $this->produkModel->getDataTable($params);
        
        // Hapus tombol hapus dari data action
        foreach ($data['data'] as &$row) {
            $row[4] = '<a href="' . BASE_URL . 'user/produk/detail/' . $row[0] . '" class="btn btn-sm btn-info">Detail</a>';
        }
        
        $this->json($data);
    }
    
    /**
     * Detail produk
     * 
     * @param int $id ID produk
     * @return void
     */
    public function detailProduk($id = null)
    {
        if (!$id) {
            $this->redirect('user/produk');
            return;
        }
        
        $produk = $this->produkModel->getProdukById($id);
        
        if (!$produk) {
            $this->session->setFlash('error', 'Produk tidak ditemukan');
            $this->redirect('user/produk');
            return;
        }
        
        $data = [
            'title' => 'Detail Produk',
            'produk' => $produk
        ];
        
        $this->renderWithSharedLayout('user/produk/detail', $data);
    }
    
    /**
     * Profil user
     * 
     * @return void
     */
    public function profil()
    {
        $user = $this->userModel->getUserById($this->session->get('user_id'));
        
        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'errors' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('user/profil');
                return;
            }
            
            // Sanitize input
            $nama = Helper::sanitize($_POST['nama'] ?? '');
            $email = Helper::sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validasi input
            $validation_rules = [
                'nama' => 'required',
                'email' => 'required|email'
            ];
            
            $validation_data = [
                'nama' => $nama,
                'email' => $email
            ];
            
            if (!empty($password)) {
                $validation_rules['password'] = 'min:6';
                $validation_rules['confirm_password'] = 'required|match:password';
                $validation_data['password'] = $password;
                $validation_data['confirm_password'] = $confirm_password;
            }
            
            $errors = $this->validate($validation_data, $validation_rules);
            
            // Cek apakah email sudah terdaftar
            if (empty($errors['email']) && $email !== $user['email'] && $this->userModel->emailExists($email)) {
                $errors['email'] = 'Email sudah terdaftar';
            }
            
            if (empty($errors)) {
                $userData = [
                    'id' => $user['id'],
                    'nama' => $nama,
                    'email' => $email
                ];
                
                if (!empty($password)) {
                    $userData['password'] = $password;
                }
                
                if ($this->userModel->update($userData)) {
                    $this->session->set('user_name', $nama);
                    $this->session->set('user_email', $email);
                    $this->session->setFlash('success', 'Profil berhasil diupdate');
                    $this->redirect('user/profil');
                } else {
                    $this->session->setFlash('error', 'Profil gagal diupdate');
                }
            } else {
                $data['errors'] = $errors;
                $data['user']['nama'] = $nama;
                $data['user']['email'] = $email;
            }
        }
        
        $this->renderWithSharedLayout('user/profil', $data);
    }
    
    /**
     * Update profil via AJAX
     * 
     * @return void
     */
    public function updateProfil()
    {
        // Hanya terima AJAX POST request
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('user/profil');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        $user = $this->userModel->getUserById($this->session->get('user_id'));
        
        // Sanitize input
        $nama = Helper::sanitize($_POST['nama'] ?? '');
        $email = Helper::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validasi input
        $validation_rules = [
            'nama' => 'required',
            'email' => 'required|email'
        ];
        
        $validation_data = [
            'nama' => $nama,
            'email' => $email
        ];
        
        if (!empty($password)) {
            $validation_rules['password'] = 'min:6';
            $validation_rules['confirm_password'] = 'required|match:password';
            $validation_data['password'] = $password;
            $validation_data['confirm_password'] = $confirm_password;
        }
        
        $errors = $this->validate($validation_data, $validation_rules);
        
        // Cek apakah email sudah terdaftar
        if (empty($errors['email']) && $email !== $user['email'] && $this->userModel->emailExists($email)) {
            $errors['email'] = 'Email sudah terdaftar';
        }
        
        if (empty($errors)) {
            $userData = [
                'id' => $user['id'],
                'nama' => $nama,
                'email' => $email
            ];
            
            if (!empty($password)) {
                $userData['password'] = $password;
            }
            
            if ($this->userModel->update($userData)) {
                $this->session->set('user_name', $nama);
                $this->session->set('user_email', $email);
                $this->json(['success' => true, 'message' => 'Profil berhasil diupdate']);
            } else {
                $this->json(['success' => false, 'message' => 'Profil gagal diupdate']);
            }
        } else {
            $this->json(['success' => false, 'errors' => $errors]);
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
            $this->redirect('user/profil');
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