<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Admin Controller
 * 
 * Controller untuk halaman admin
 */
class AdminController extends Controller
{
    private $userModel;
    private $produkModel;
    
    /**
     * Constructor
     * Load dependency dan cek akses admin
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
        
        // Cek apakah user adalah admin
        if ($this->session->get('user_role') !== 'admin') {
            Helper::redirect('user/dashboard');
            exit;
        }
    }
    
    /**
     * Halaman dashboard admin
     * 
     * @return void
     */
    public function dashboard()
    {
        $totalProduk = $this->produkModel->countProduk();
        $totalNilaiStok = $this->produkModel->countTotalNilaiStok();
        $produkTerbaru = $this->produkModel->getProdukTerbaru(5);
        $chartData = $this->produkModel->getProdukForChart(10);
        
        $data = [
            'title' => 'Dashboard Admin',
            'totalProduk' => $totalProduk,
            'totalNilaiStok' => $totalNilaiStok,
            'produkTerbaru' => $produkTerbaru,
            'chartData' => $chartData
        ];
        
        $this->renderWithSharedLayout('admin/dashboard', $data);
    }
    
    /**
     * Metode index - redirect ke dashboard
     * 
     * @return void
     */
    public function index()
    {
        $this->redirect('admin/dashboard');
    }
    
    /**
     * Kelola produk
     * 
     * @return void
     */
    public function produk()
    {
        $data = [
            'title' => 'Kelola Produk'
        ];
        
        $this->renderWithSharedLayout('admin/produk/index', $data);
    }
    
    /**
     * Get data untuk DataTables produk
     * 
     * @return void
     */
    public function getProdukData()
    {
        if (!Helper::isAjax()) {
            $this->redirect('admin/produk');
            return;
        }
        
        $params = $_GET;
        $data = $this->produkModel->getDataTable($params);
        
        $this->json($data);
    }
    
    /**
     * Tambah produk
     * 
     * @return void
     */
    public function tambahProduk()
    {
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debugging: log headers dan request untuk debugging
            error_log('Request Headers: ' . json_encode(getallheaders()));
            error_log('Request POST: ' . json_encode($_POST));
            error_log('Session CSRF: ' . ($_SESSION[CSRF_TOKEN_NAME] ?? 'tidak tersedia'));
            
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
                return;
            }
            
            // Sanitize input
            $nama_produk = Helper::sanitize($_POST['nama_produk'] ?? '');
            $harga = Helper::sanitize($_POST['harga'] ?? '');
            $stok = Helper::sanitize($_POST['stok'] ?? '');
            $deskripsi = Helper::sanitize($_POST['deskripsi'] ?? '');
            
            // Validasi input
            $errors = $this->validate(
                [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ],
                [
                    'nama_produk' => 'required',
                    'harga' => 'required|numeric',
                    'stok' => 'required|numeric'
                ]
            );
            
            if (empty($errors)) {
                $produkData = [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok,
                    'deskripsi' => $deskripsi
                ];
                
                if ($this->produkModel->tambahProduk($produkData)) {
                    $this->json(['success' => true, 'message' => 'Produk berhasil ditambahkan']);
                } else {
                    $this->json(['success' => false, 'message' => 'Produk gagal ditambahkan'], 500);
                }
            } else {
                $errorMsg = 'Validasi gagal: ';
                foreach ($errors as $field => $error) {
                    $errorMsg .= $field . ' - ' . $error . ', ';
                }
                $errorMsg = rtrim($errorMsg, ', ');
                $this->json(['success' => false, 'message' => $errorMsg], 400);
            }
            return;
        }
        
        // Jika request halaman biasa (non-AJAX)
        $data = [
            'title' => 'Tambah Produk',
            'errors' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('admin/produk');
                return;
            }
            
            // Sanitize input
            $nama_produk = Helper::sanitize($_POST['nama_produk'] ?? '');
            $harga = Helper::sanitize($_POST['harga'] ?? '');
            $stok = Helper::sanitize($_POST['stok'] ?? '');
            
            // Validasi input
            $errors = $this->validate(
                [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ],
                [
                    'nama_produk' => 'required',
                    'harga' => 'required|numeric',
                    'stok' => 'required|numeric'
                ]
            );
            
            if (empty($errors)) {
                $produkData = [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ];
                
                if ($this->produkModel->tambahProduk($produkData)) {
                    $this->session->setFlash('success', 'Produk berhasil ditambahkan');
                    $this->redirect('admin/produk');
                } else {
                    $this->session->setFlash('error', 'Produk gagal ditambahkan');
                }
            } else {
                $data['errors'] = $errors;
                $data['nama_produk'] = $nama_produk;
                $data['harga'] = $harga;
                $data['stok'] = $stok;
            }
        }
        
        $this->renderWithSharedLayout('admin/produk/tambah', $data);
    }
    
    /**
     * Edit produk
     * 
     * @param int $id ID produk
     * @return void
     */
    public function editProduk($id = null)
    {
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debugging: log headers dan request untuk debugging
            error_log('Edit Produk - Request Headers: ' . json_encode(getallheaders()));
            error_log('Edit Produk - Request POST: ' . json_encode($_POST));
            error_log('Edit Produk - Session CSRF: ' . ($_SESSION[CSRF_TOKEN_NAME] ?? 'tidak tersedia'));
            
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
                return;
            }
            
            // Sanitize input
            $id = Helper::sanitize($_POST['id'] ?? '');
            $nama_produk = Helper::sanitize($_POST['nama_produk'] ?? '');
            $harga = Helper::sanitize($_POST['harga'] ?? '');
            $stok = Helper::sanitize($_POST['stok'] ?? '');
            $deskripsi = Helper::sanitize($_POST['deskripsi'] ?? '');
            
            if (!$id) {
                $this->json(['success' => false, 'message' => 'ID produk tidak valid'], 400);
                return;
            }
            
            $produk = $this->produkModel->getProdukById($id);
            
            if (!$produk) {
                $this->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
                return;
            }
            
            // Validasi input
            $errors = $this->validate(
                [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ],
                [
                    'nama_produk' => 'required',
                    'harga' => 'required|numeric',
                    'stok' => 'required|numeric'
                ]
            );
            
            if (empty($errors)) {
                $produkData = [
                    'id' => $id,
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok,
                    'deskripsi' => $deskripsi
                ];
                
                if ($this->produkModel->updateProduk($produkData)) {
                    $this->json(['success' => true, 'message' => 'Produk berhasil diupdate']);
                } else {
                    $this->json(['success' => false, 'message' => 'Produk gagal diupdate'], 500);
                }
            } else {
                $errorMsg = 'Validasi gagal: ';
                foreach ($errors as $field => $error) {
                    $errorMsg .= $field . ' - ' . $error . ', ';
                }
                $errorMsg = rtrim($errorMsg, ', ');
                $this->json(['success' => false, 'message' => $errorMsg], 400);
            }
            return;
        }
        
        // Jika request halaman biasa (non-AJAX) atau GET request
        if (!$id) {
            $this->redirect('admin/produk');
            return;
        }
        
        $produk = $this->produkModel->getProdukById($id);
        
        if (!$produk) {
            $this->session->setFlash('error', 'Produk tidak ditemukan');
            $this->redirect('admin/produk');
            return;
        }
        
        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'errors' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('admin/produk');
                return;
            }
            
            // Sanitize input
            $nama_produk = Helper::sanitize($_POST['nama_produk'] ?? '');
            $harga = Helper::sanitize($_POST['harga'] ?? '');
            $stok = Helper::sanitize($_POST['stok'] ?? '');
            
            // Validasi input
            $errors = $this->validate(
                [
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ],
                [
                    'nama_produk' => 'required',
                    'harga' => 'required|numeric',
                    'stok' => 'required|numeric'
                ]
            );
            
            if (empty($errors)) {
                $produkData = [
                    'id' => $id,
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok
                ];
                
                if ($this->produkModel->updateProduk($produkData)) {
                    $this->session->setFlash('success', 'Produk berhasil diupdate');
                    $this->redirect('admin/produk');
                } else {
                    $this->session->setFlash('error', 'Produk gagal diupdate');
                }
            } else {
                $data['errors'] = $errors;
                $data['produk']['nama_produk'] = $nama_produk;
                $data['produk']['harga'] = $harga;
                $data['produk']['stok'] = $stok;
            }
        }
        
        $this->renderWithSharedLayout('admin/produk/edit', $data);
    }
    
    /**
     * Hapus produk
     * 
     * @return void
     */
    public function hapusProduk()
    {
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/produk');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            $this->json(['success' => false, 'message' => 'ID produk tidak valid'], 400);
            return;
        }
        
        if ($this->produkModel->hapusProduk($id)) {
            $this->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
        } else {
            $this->json(['success' => false, 'message' => 'Produk gagal dihapus'], 500);
        }
    }
    
    /**
     * User - menampilkan daftar user
     * 
     * @return void
     */
    public function user()
    {
        $data = [
            'title' => 'Kelola User'
        ];
        
        $this->renderWithSharedLayout('admin/user/index', $data);
    }

    /**
     * Get data untuk DataTables user
     * 
     * @return void
     */
    public function getUserData()
    {
        if (!Helper::isAjax()) {
            $this->redirect('admin/user');
            return;
        }
        
        $params = $_GET;
        $data = $this->userModel->getDataTable($params);
        
        $this->json($data);
    }
    
    /**
     * Tambah user
     * 
     * @return void
     */
    public function tambahUser()
    {
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debugging: log headers dan request untuk debugging
            error_log('Tambah User - Request Headers: ' . json_encode(getallheaders()));
            error_log('Tambah User - Request POST: ' . json_encode($_POST));
            error_log('Tambah User - Session CSRF: ' . ($_SESSION[CSRF_TOKEN_NAME] ?? 'tidak tersedia'));
            
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
                return;
            }
            
            // Sanitize input
            $nama = Helper::sanitize($_POST['nama'] ?? '');
            $email = Helper::sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = Helper::sanitize($_POST['role'] ?? 'user');
            
            // Validasi input
            $errors = $this->validate(
                [
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                ],
                [
                    'nama' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                    'role' => 'required|in:admin,user'
                ]
            );
            
            // Cek apakah email sudah terdaftar
            if (empty($errors['email']) && $this->userModel->emailExists($email)) {
                $errors['email'] = 'Email sudah digunakan';
            }
            
            if (empty($errors)) {
                $userData = [
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role
                ];
                
                if ($this->userModel->tambahUser($userData)) {
                    $this->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan']);
                } else {
                    $this->json(['success' => false, 'message' => 'Pengguna gagal ditambahkan'], 500);
                }
            } else {
                $errorMsg = 'Validasi gagal: ';
                foreach ($errors as $field => $error) {
                    $errorMsg .= $field . ' - ' . $error . ', ';
                }
                $errorMsg = rtrim($errorMsg, ', ');
                $this->json(['success' => false, 'message' => $errorMsg, 'errors' => $errors], 400);
            }
            return;
        }
        
        $this->redirect('admin/user');
    }
    
    /**
     * Edit user
     * 
     * @return void
     */
    public function editUser()
    {
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debugging: log headers dan request untuk debugging
            error_log('Edit User - Request Headers: ' . json_encode(getallheaders()));
            error_log('Edit User - Request POST: ' . json_encode($_POST));
            error_log('Edit User - Session CSRF: ' . ($_SESSION[CSRF_TOKEN_NAME] ?? 'tidak tersedia'));
            
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
                return;
            }
            
            // Sanitize input
            $id = Helper::sanitize($_POST['id'] ?? '');
            $nama = Helper::sanitize($_POST['nama'] ?? '');
            $email = Helper::sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? ''; // Jangan sanitize password
            $role = Helper::sanitize($_POST['role'] ?? 'user');
            
            if (!$id) {
                $this->json(['success' => false, 'message' => 'ID pengguna tidak valid'], 400);
                return;
            }
            
            $user = $this->userModel->getUserById($id);
            
            if (!$user) {
                $this->json(['success' => false, 'message' => 'Pengguna tidak ditemukan'], 404);
                return;
            }
            
            // Validasi input
            $validation_rules = [
                'nama' => 'required',
                'email' => 'required|email',
                'role' => 'required|in:admin,user'
            ];
            
            $validation_data = [
                'nama' => $nama,
                'email' => $email,
                'role' => $role
            ];
            
            // Jika password diisi, validasi
            if (!empty($password)) {
                $validation_rules['password'] = 'min:6';
                $validation_data['password'] = $password;
            }
            
            $errors = $this->validate($validation_data, $validation_rules);
            
            // Cek apakah email sudah terdaftar oleh user lain
            if (empty($errors['email']) && $email !== $user['email'] && $this->userModel->emailExists($email)) {
                $errors['email'] = 'Email sudah digunakan oleh pengguna lain';
            }
            
            if (empty($errors)) {
                $userData = [
                    'id' => $id,
                    'nama' => $nama,
                    'email' => $email,
                    'role' => $role
                ];
                
                // Hanya tambahkan password jika diisi
                if (!empty($password)) {
                    $userData['password'] = $password;
                }
                
                if ($this->userModel->update($userData)) {
                    $this->json(['success' => true, 'message' => 'Pengguna berhasil diupdate']);
                } else {
                    $this->json(['success' => false, 'message' => 'Pengguna gagal diupdate'], 500);
                }
            } else {
                $errorMsg = 'Validasi gagal: ';
                foreach ($errors as $field => $error) {
                    $errorMsg .= $field . ' - ' . $error . ', ';
                }
                $errorMsg = rtrim($errorMsg, ', ');
                $this->json(['success' => false, 'message' => $errorMsg, 'errors' => $errors], 400);
            }
            return;
        }
        
        $this->redirect('admin/user');
    }
    
    /**
     * Hapus user
     * 
     * @return void
     */
    public function hapusUser()
    {
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/user');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        $id = Helper::sanitize($_POST['id'] ?? '');
        
        if (!$id) {
            $this->json(['success' => false, 'message' => 'ID pengguna tidak valid'], 400);
            return;
        }
        
        // Cek jika user mencoba menghapus diri sendiri
        if ($id == $this->session->get('user_id')) {
            $this->json(['success' => false, 'message' => 'Anda tidak dapat menghapus akun yang sedang digunakan'], 400);
            return;
        }
        
        if ($this->userModel->hapusUser($id)) {
            $this->json(['success' => true, 'message' => 'Pengguna berhasil dihapus']);
        } else {
            $this->json(['success' => false, 'message' => 'Pengguna gagal dihapus'], 500);
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
            $this->redirect('admin/produk');
            return;
        }
        
        $csrf = new \core\CSRF();
        $token = $csrf->regenerateToken();
        
        $this->json([
            'success' => true,
            'token' => $token
        ]);
    }

    /**
     * Profil admin
     * 
     * @return void
     */
    public function profil()
    {
        $user = $this->userModel->getUserById($this->session->get('user_id'));
        
        $data = [
            'title' => 'Profil Admin',
            'user' => $user,
            'errors' => []
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('admin/profil');
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
                    $this->redirect('admin/profil');
                } else {
                    $this->session->setFlash('error', 'Profil gagal diupdate');
                }
            } else {
                $data['errors'] = $errors;
                $data['user']['nama'] = $nama;
                $data['user']['email'] = $email;
            }
        }
        
        $this->renderWithSharedLayout('admin/profil', $data);
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
            $this->redirect('admin/profil');
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
     * Halaman pengaturan admin
     * 
     * @return void
     */
    public function pengaturan()
    {
        $data = [
            'title' => 'Pengaturan Website'
        ];
        
        // Pengaturan situs dari database atau file konfigurasi (contoh statis untuk MVP)
        $pengaturan = [
            'nama_situs' => 'Inventory System',
            'tagline' => 'Sistem manajemen inventori produk yang mudah digunakan',
            'deskripsi' => 'Aplikasi web untuk mengelola stok produk, pemantauan inventaris, dan manajemen user.',
            'email_admin' => 'admin@example.com',
            'alamat' => 'Jl. Contoh No. 123, Jakarta',
            'telepon' => '021-12345678',
            'logo_path' => 'template/images/logo-dark-text.png',
            'favicon_path' => 'template/images/favicon.ico',
            'footer_text' => 'Copyright © ' . date('Y') . ' Inventory System. All rights reserved.',
        ];
        
        $data['pengaturan'] = $pengaturan;
        
        $this->renderWithSharedLayout('admin/pengaturan', $data);
    }
} 