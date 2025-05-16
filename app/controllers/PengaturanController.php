<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Pengaturan Controller
 * 
 * Controller untuk menangani pengaturan website (khusus admin)
 */
class PengaturanController extends Controller
{
    private $userModel;
    private $pengaturanModel;
    
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
        $this->pengaturanModel = $this->model('Pengaturan');
        
        // Cek apakah user sudah login
        if (!$this->session->has('user_id')) {
            Helper::redirect('auth');
            exit;
        }
        
        // Cek apakah user adalah admin
        if ($this->session->get('user_role') !== 'admin') {
            Helper::redirect('dashboard');
            exit;
        }
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
            'tagline' => 'Administrator Panel',
            'logo_path' => 'assets/images/logo.png',
            'favicon_path' => 'assets/images/favicon.ico',
        ];
        
        // Gabungkan default dengan pengaturan dari database
        return array_merge($defaultPengaturan, $pengaturan);
    }
    
    /**
     * Halaman pengaturan website
     * 
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => 'Pengaturan Website',
            'pengaturan' => $this->getPengaturanData(),
            'isAdmin' => true
        ];
        
        $this->renderWithSharedLayout('pengaturan/index', $data);
    }
    
    /**
     * Simpan pengaturan umum website
     * 
     * @return void
     */
    public function simpanPengaturanUmum()
    {
        // Validasi request AJAX
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('pengaturan');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        // Sanitize input
        $namaSitus = Helper::sanitize($_POST['nama_situs'] ?? '');
        $tagline = Helper::sanitize($_POST['tagline'] ?? '');
        $deskripsi = Helper::sanitize($_POST['deskripsi'] ?? '');
        $emailAdmin = Helper::sanitize($_POST['email_admin'] ?? '');
        $alamat = Helper::sanitize($_POST['alamat'] ?? '');
        $telepon = Helper::sanitize($_POST['telepon'] ?? '');
        $footerText = Helper::sanitize($_POST['footer_text'] ?? '');
        
        // Validasi input
        $errors = $this->validate(
            [
                'nama_situs' => $namaSitus,
                'email_admin' => $emailAdmin
            ],
            [
                'nama_situs' => 'required',
                'email_admin' => 'required|email'
            ]
        );
        
        if (!empty($errors)) {
            $this->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $errors], 400);
            return;
        }
        
        // Persiapkan data pengaturan
        $pengaturanData = [
            'nama_situs' => $namaSitus,
            'tagline' => $tagline,
            'deskripsi' => $deskripsi,
            'email_admin' => $emailAdmin,
            'alamat' => $alamat,
            'telepon' => $telepon,
            'footer_text' => $footerText
        ];
        
        // Simpan pengaturan
        if ($this->pengaturanModel->updateMultiplePengaturan($pengaturanData)) {
            $this->json(['success' => true, 'message' => 'Pengaturan website berhasil disimpan']);
        } else {
            $this->json(['success' => false, 'message' => 'Gagal menyimpan pengaturan website'], 500);
        }
    }
    
    /**
     * Simpan logo dan favicon
     * 
     * @return void
     */
    public function simpanLogoFavicon()
    {
        // Validasi request AJAX
        if (!Helper::isAjax() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('pengaturan');
            return;
        }
        
        // Verifikasi CSRF token
        if (!$this->verifyCsrfToken()) {
            $this->json(['success' => false, 'message' => 'CSRF token tidak valid'], 403);
            return;
        }
        
        $pengaturanData = [];
        $messages = [];
        $success = true;
        
        // Handle logo upload
        if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
            $logoResult = $this->pengaturanModel->uploadFile($_FILES['logo'], 'logo');
            
            if ($logoResult['success']) {
                $pengaturanData['logo_path'] = $logoResult['path'];
                $messages[] = 'Logo berhasil diupload';
            } else {
                $success = false;
                $messages[] = 'Logo: ' . $logoResult['message'];
            }
        }
        
        // Handle favicon upload
        if (isset($_FILES['favicon']) && !empty($_FILES['favicon']['name'])) {
            $faviconResult = $this->pengaturanModel->uploadFile($_FILES['favicon'], 'favicon');
            
            if ($faviconResult['success']) {
                $pengaturanData['favicon_path'] = $faviconResult['path'];
                $messages[] = 'Favicon berhasil diupload';
            } else {
                $success = false;
                $messages[] = 'Favicon: ' . $faviconResult['message'];
            }
        }
        
        // Jika tidak ada file yang diupload
        if (empty($pengaturanData)) {
            $this->json(['success' => false, 'message' => 'Tidak ada file yang dipilih']);
            return;
        }
        
        // Simpan pengaturan jika ada file yang berhasil diupload
        if (!empty($pengaturanData)) {
            if ($this->pengaturanModel->updateMultiplePengaturan($pengaturanData)) {
                $this->json([
                    'success' => $success,
                    'message' => implode(', ', $messages)
                ]);
            } else {
                $this->json(['success' => false, 'message' => 'Gagal menyimpan pengaturan file'], 500);
            }
        } else {
            $this->json(['success' => false, 'message' => implode(', ', $messages)], 400);
        }
    }
} 