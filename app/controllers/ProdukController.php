<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Produk Controller
 * 
 * Controller untuk manajemen produk (admin dan user)
 */
class ProdukController extends Controller
{
    private $userModel;
    private $produkModel;
    private $pengaturanModel;
    private $isAdmin = false;
    
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
     * Daftar produk
     * 
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => $this->isAdmin ? 'Kelola Produk' : 'Daftar Produk',
            'isAdmin' => $this->isAdmin,
            'pengaturan' => $this->getPengaturanData()
        ];
        
        $this->renderWithSharedLayout('produk/index', $data);
    }
    
    /**
     * Get data untuk DataTables produk
     * 
     * @return void
     */
    public function getData()
    {
        // Log untuk debugging
        error_log('ProdukController::getData dipanggil');
        
        if (!Helper::isAjax()) {
            error_log('Request bukan AJAX, redirect ke produk');
            $this->redirect('produk');
            return;
        }
        
        try {
            $params = $_GET;
            error_log('Params: ' . json_encode($params));
            
            $data = $this->produkModel->getDataTable($params);
            error_log('Data dari model: ' . json_encode(array_slice($data, 0, 2))); // Log sebagian data saja
            
            // Untuk user biasa, hapus tombol hapus dari data action
            if (!$this->isAdmin) {
                foreach ($data['data'] as &$row) {
                    $row[4] = '<a href="' . BASE_URL . 'produk/detail/' . $row[0] . '" class="btn btn-sm btn-info">Detail</a> 
                              <a href="' . BASE_URL . 'produk/edit/' . $row[0] . '" class="btn btn-sm btn-warning">Edit</a>';
                }
            }
            
            error_log('Mengirim response JSON');
            $this->json($data);
        } catch (\Exception $e) {
            error_log('Error di ProdukController::getData: ' . $e->getMessage());
            $this->json(['error' => 'Internal server error', 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Tambah produk
     * 
     * @return void
     */
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Produk',
            'errors' => [],
            'isAdmin' => $this->isAdmin,
            'pengaturan' => $this->getPengaturanData()
        ];
        
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('produk');
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
                    $this->session->setFlash('success', 'Produk berhasil ditambahkan');
                    $this->redirect('produk');
                } else {
                    $this->session->setFlash('error', 'Produk gagal ditambahkan');
                }
            } else {
                $data['errors'] = $errors;
                $data['nama_produk'] = $nama_produk;
                $data['harga'] = $harga;
                $data['stok'] = $stok;
                $data['deskripsi'] = $deskripsi;
            }
        }
        
        $this->renderWithSharedLayout('produk/tambah', $data);
    }
    
    /**
     * Edit produk
     * 
     * @param int $id ID produk
     * @return void
     */
    public function edit($id = null)
    {
        if (!$id) {
            $this->redirect('produk');
            return;
        }
        
        $produk = $this->produkModel->getProdukById($id);
        
        if (!$produk) {
            $this->session->setFlash('error', 'Produk tidak ditemukan');
            $this->redirect('produk');
            return;
        }
        
        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'errors' => [],
            'isAdmin' => $this->isAdmin,
            'pengaturan' => $this->getPengaturanData()
        ];
        
        // Jika request dari AJAX (form modal)
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->session->setFlash('error', 'CSRF token tidak valid');
                $this->redirect('produk');
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
                    'id' => $id,
                    'nama_produk' => $nama_produk,
                    'harga' => $harga,
                    'stok' => $stok,
                    'deskripsi' => $deskripsi
                ];
                
                if ($this->produkModel->updateProduk($produkData)) {
                    $this->session->setFlash('success', 'Produk berhasil diupdate');
                    $this->redirect('produk');
                } else {
                    $this->session->setFlash('error', 'Produk gagal diupdate');
                }
            } else {
                $data['errors'] = $errors;
                $data['produk']['nama_produk'] = $nama_produk;
                $data['produk']['harga'] = $harga;
                $data['produk']['stok'] = $stok;
                $data['produk']['deskripsi'] = $deskripsi;
            }
        }
        
        $this->renderWithSharedLayout('produk/edit', $data);
    }
    
    /**
     * Detail produk
     * 
     * @param int $id ID produk
     * @return void
     */
    public function detail($id = null)
    {
        // Log untuk debugging
        error_log('ProdukController::detail dipanggil dengan ID: ' . $id);
        error_log('Request type: ' . (Helper::isAjax() ? 'AJAX' : 'Regular Browser'));
        
        if (!$id) {
            if (Helper::isAjax()) {
                error_log('ID produk tidak valid, kirim respon JSON error');
                $this->json(['success' => false, 'message' => 'ID produk tidak valid'], 400);
                return;
            } else {
                error_log('ID produk tidak valid, redirect ke produk');
                $this->redirect('produk');
                return;
            }
        }
        
        try {
            error_log('Mencoba mengambil data produk dengan ID: ' . $id);
            $produk = $this->produkModel->getProdukById($id);
            
            if (!$produk) {
                if (Helper::isAjax()) {
                    error_log('Produk tidak ditemukan, kirim respon JSON error');
                    $this->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
                    return;
                } else {
                    error_log('Produk tidak ditemukan, redirect ke produk');
                    $this->session->setFlash('error', 'Produk tidak ditemukan');
                    $this->redirect('produk');
                    return;
                }
            }
            
            error_log('Data produk ditemukan: ' . json_encode($produk));
            
            // Jika request dari AJAX, kirim respon JSON
            if (Helper::isAjax()) {
                error_log('Kirim respon JSON data produk');
                $this->json([
                    'success' => true,
                    'data' => $produk
                ]);
                return;
            }
            
            // Jika request biasa, tampilkan halaman detail
            error_log('Render halaman detail produk');
            $data = [
                'title' => 'Detail Produk',
                'produk' => $produk,
                'isAdmin' => $this->isAdmin,
                'pengaturan' => $this->getPengaturanData()
            ];
            
            $this->renderWithSharedLayout('produk/detail', $data);
        } catch (\Exception $e) {
            error_log('Error di ProdukController::detail: ' . $e->getMessage());
            if (Helper::isAjax()) {
                $this->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            } else {
                $this->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                $this->redirect('produk');
            }
        }
    }
    
    /**
     * Hapus produk
     * 
     * @return void
     */
    public function hapus()
    {
        // Hanya admin yang bisa menghapus produk
        if (!$this->isAdmin) {
            if (Helper::isAjax()) {
                $this->json(['success' => false, 'message' => 'Anda tidak memiliki hak akses untuk menghapus produk'], 403);
            } else {
                $this->session->setFlash('error', 'Anda tidak memiliki hak akses untuk menghapus produk');
                $this->redirect('produk');
            }
            return;
        }
        
        // Jika request dari AJAX
        if (Helper::isAjax() && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifikasi CSRF token
            if (!$this->verifyCsrfToken()) {
                $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
                return;
            }
            
            $id = Helper::sanitize($_POST['id'] ?? '');
            
            if (empty($id)) {
                $this->json(['success' => false, 'message' => 'ID produk tidak valid'], 400);
                return;
            }
            
            if ($this->produkModel->hapusProduk($id)) {
                $this->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
            } else {
                $this->json(['success' => false, 'message' => 'Produk gagal dihapus'], 500);
            }
        } else {
            $this->redirect('produk');
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
            $this->redirect('produk');
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