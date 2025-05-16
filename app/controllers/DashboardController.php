<?php
namespace controllers;

use core\Controller;
use core\Helper;

/**
 * Dashboard Controller
 * 
 * Controller untuk menangani halaman dashboard baik admin maupun user biasa
 */
class DashboardController extends Controller
{
    private $userModel;
    private $produkModel;
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
     * Halaman dashboard - menampilkan dashboard sesuai dengan role user
     * 
     * @return void
     */
    public function index()
    {
        $totalProduk = $this->produkModel->countProduk();
        $produkTerbaru = $this->produkModel->getProdukTerbaru(5);
        $chartData = $this->produkModel->getProdukForChart(10);
        
        $data = [
            'title' => $this->isAdmin ? 'Dashboard Admin' : 'Dashboard User',
            'totalProduk' => $totalProduk,
            'produkTerbaru' => $produkTerbaru,
            'chartData' => $chartData,
            'isAdmin' => $this->isAdmin,
            'pengaturan' => $this->getPengaturanData()
        ];
        
        // Tambahkan data khusus untuk admin
        if ($this->isAdmin) {
            $data['totalNilaiStok'] = $this->produkModel->countTotalNilaiStok();
        }
        
        $this->renderWithSharedLayout('dashboard/index', $data);
    }
} 