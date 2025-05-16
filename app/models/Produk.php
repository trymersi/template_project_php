<?php
namespace models;

use core\Database;

/**
 * Produk Model
 * 
 * Model untuk menangani operasi CRUD produk
 */
class Produk
{
    private $db;
    
    /**
     * Constructor
     * Inisialisasi koneksi database
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    
    /**
     * Get semua produk
     * 
     * @return array Data semua produk
     */
    public function getAllProduk()
    {
        $this->db->query('SELECT * FROM produk ORDER BY id DESC');
        return $this->db->resultSet();
    }
    
    /**
     * Get produk by ID
     * 
     * @param int $id ID produk
     * @return array|bool Data produk jika ditemukan, false jika tidak
     */
    public function getProdukById($id)
    {
        $this->db->query('SELECT * FROM produk WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $produk = $this->db->single();
        
        if ($produk) {
            // Format tanggal untuk tampilan
            $helper = new \core\Helper();
            if (!empty($produk['created_at'])) {
                $produk['created_at'] = $helper->formatDate($produk['created_at']);
            }
            if (!empty($produk['updated_at'])) {
                $produk['updated_at'] = $helper->formatDate($produk['updated_at']);
            }
        }
        
        return $produk;
    }
    
    /**
     * Tambah produk baru
     * 
     * @param array $data Data produk
     * @return bool True jika berhasil, false jika gagal
     */
    public function tambahProduk($data)
    {
        $this->db->query('INSERT INTO produk (nama_produk, harga, stok, deskripsi) VALUES (:nama_produk, :harga, :stok, :deskripsi)');
        $this->db->bind(':nama_produk', $data['nama_produk']);
        $this->db->bind(':harga', $data['harga']);
        $this->db->bind(':stok', $data['stok']);
        $this->db->bind(':deskripsi', $data['deskripsi'] ?? null);
        
        return $this->db->execute();
    }
    
    /**
     * Update produk
     * 
     * @param array $data Data produk
     * @return bool True jika berhasil, false jika gagal
     */
    public function updateProduk($data)
    {
        $this->db->query('UPDATE produk SET nama_produk = :nama_produk, harga = :harga, stok = :stok, deskripsi = :deskripsi WHERE id = :id');
        $this->db->bind(':nama_produk', $data['nama_produk']);
        $this->db->bind(':harga', $data['harga']);
        $this->db->bind(':stok', $data['stok']);
        $this->db->bind(':deskripsi', $data['deskripsi'] ?? null);
        $this->db->bind(':id', $data['id']);
        
        return $this->db->execute();
    }
    
    /**
     * Hapus produk
     * 
     * @param int $id ID produk
     * @return bool True jika berhasil, false jika gagal
     */
    public function hapusProduk($id)
    {
        $this->db->query('DELETE FROM produk WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Get produk terbaru
     * 
     * @param int $limit Jumlah produk yang diambil
     * @return array Data produk terbaru
     */
    public function getProdukTerbaru($limit = 5)
    {
        $this->db->query('SELECT * FROM produk ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, \PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
    
    /**
     * Hitung total produk
     * 
     * @return int Jumlah total produk
     */
    public function countProduk()
    {
        $this->db->query('SELECT COUNT(*) as total FROM produk');
        $result = $this->db->single();
        
        return $result['total'];
    }
    
    /**
     * Hitung total nilai stok
     * 
     * @return float Total nilai stok (harga * stok)
     */
    public function countTotalNilaiStok()
    {
        $this->db->query('SELECT SUM(harga * stok) as total FROM produk');
        $result = $this->db->single();
        
        return $result['total'] ?? 0;
    }
    
    /**
     * Get data untuk server-side DataTables
     * 
     * @param array $params Parameter dari DataTables
     * @return array Data untuk DataTables
     */
    public function getDataTable($params)
    {
        // Set default
        $columns = [
            0 => 'id',
            1 => 'nama_produk',
            2 => 'harga',
            3 => 'stok',
            4 => 'created_at'
        ];
        
        // Total data
        $totalData = $this->countProduk();
        $totalFiltered = $totalData;
        
        // Default limit dan offset
        $limit = $params['length'] ?? 10;
        $start = $params['start'] ?? 0;
        
        // Order
        $order = '';
        if (isset($params['order']) && $params['order'][0]['column'] >= 0) {
            $columnIdx = $params['order'][0]['column'];
            $dir = $params['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
            $order = 'ORDER BY ' . $columns[$columnIdx] . ' ' . $dir;
        } else {
            $order = 'ORDER BY id DESC';
        }
        
        // Search
        $where = '';
        $search = $params['search']['value'] ?? '';
        if (!empty($search)) {
            $where = "WHERE nama_produk LIKE :search OR id LIKE :search";
        }
        
        // Query data
        $sql = "SELECT * FROM produk $where $order LIMIT :start, :limit";
        $this->db->query($sql);
        
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        
        $this->db->bind(':start', $start, \PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, \PDO::PARAM_INT);
        
        $data = $this->db->resultSet();
        
        // Count filtered data
        if (!empty($search)) {
            $sql = "SELECT COUNT(*) as total FROM produk $where";
            $this->db->query($sql);
            $this->db->bind(':search', '%' . $search . '%');
            $result = $this->db->single();
            $totalFiltered = $result['total'];
        }
        
        // Format data
        $formattedData = [];
        foreach ($data as $row) {
            $subdata = [];
            $subdata[] = $row['id'];
            $subdata[] = $row['nama_produk'];
            $subdata[] = $row['harga'];
            $subdata[] = $row['stok'];
            
            // Action buttons
            $subdata[] = '
                <button type="button" class="btn btn-sm btn-warning btn-edit" 
                    data-id="' . $row['id'] . '" 
                    data-nama="' . htmlspecialchars($row['nama_produk']) . '" 
                    data-harga="' . $row['harga'] . '" 
                    data-stok="' . $row['stok'] . '" 
                    data-deskripsi="' . htmlspecialchars($row['deskripsi'] ?? '') . '">
                    <i class="ti-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row['id'] . '">
                    <i class="ti-trash"></i> Hapus
                </button>
            ';
            
            $formattedData[] = $subdata;
        }
        
        // Response untuk DataTables
        return [
            'draw' => intval($params['draw'] ?? 0),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $formattedData,
        ];
    }
    
    /**
     * Get produk untuk chart
     * 
     * @param int $limit Jumlah produk yang diambil
     * @return array Data produk untuk chart
     */
    public function getProdukForChart($limit = 10)
    {
        $this->db->query('SELECT nama_produk, stok FROM produk ORDER BY stok DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, \PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
} 