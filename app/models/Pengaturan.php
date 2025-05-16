<?php
namespace models;

use core\Database;

/**
 * Pengaturan Model
 * 
 * Model untuk menangani operasi CRUD pengaturan website
 */
class Pengaturan
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
     * Get semua pengaturan
     * 
     * @return array Data pengaturan dalam bentuk key-value
     */
    public function getAllPengaturan()
    {
        $this->db->query('SELECT * FROM pengaturan');
        $result = $this->db->resultSet();
        
        $pengaturan = [];
        foreach ($result as $row) {
            $pengaturan[$row['kode']] = $row['nilai'];
        }
        
        return $pengaturan;
    }
    
    /**
     * Get pengaturan berdasarkan kode
     * 
     * @param string $kode Kode pengaturan
     * @return string|null Nilai pengaturan atau null jika tidak ditemukan
     */
    public function getPengaturan($kode)
    {
        $this->db->query('SELECT nilai FROM pengaturan WHERE kode = :kode');
        $this->db->bind(':kode', $kode);
        
        $result = $this->db->single();
        
        return $result ? $result['nilai'] : null;
    }
    
    /**
     * Update atau insert pengaturan
     * 
     * @param string $kode Kode pengaturan
     * @param string $nilai Nilai pengaturan
     * @return bool True jika berhasil, false jika gagal
     */
    public function updatePengaturan($kode, $nilai)
    {
        // Cek apakah pengaturan sudah ada
        $this->db->query('SELECT COUNT(*) as count FROM pengaturan WHERE kode = :kode');
        $this->db->bind(':kode', $kode);
        
        $result = $this->db->single();
        
        if ($result['count'] > 0) {
            // Update pengaturan yang sudah ada
            $this->db->query('UPDATE pengaturan SET nilai = :nilai WHERE kode = :kode');
        } else {
            // Insert pengaturan baru
            $this->db->query('INSERT INTO pengaturan (kode, nilai) VALUES (:kode, :nilai)');
        }
        
        $this->db->bind(':kode', $kode);
        $this->db->bind(':nilai', $nilai);
        
        return $this->db->execute();
    }
    
    /**
     * Update multiple pengaturan sekaligus
     * 
     * @param array $data Data pengaturan dalam bentuk key-value
     * @return bool True jika semua berhasil, false jika ada yang gagal
     */
    public function updateMultiplePengaturan($data)
    {
        $success = true;
        
        $this->db->beginTransaction();
        
        try {
            foreach ($data as $kode => $nilai) {
                if (!$this->updatePengaturan($kode, $nilai)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $this->db->commit();
            } else {
                $this->db->rollBack();
            }
        } catch (\Exception $e) {
            $this->db->rollBack();
            $success = false;
        }
        
        return $success;
    }
    
    /**
     * Upload dan simpan file (logo dan favicon)
     * 
     * @param array $file Data file dari $_FILES
     * @param string $type Jenis file ('logo' atau 'favicon')
     * @return array Status upload dan path file jika berhasil
     */
    public function uploadFile($file, $type)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'ico'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        $result = [
            'success' => false,
            'message' => '',
            'path' => ''
        ];
        
        // Cek apakah ada file yang diupload
        if (!isset($file['name']) || empty($file['name'])) {
            $result['message'] = 'Tidak ada file yang dipilih';
            return $result;
        }
        
        // Cek error upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['message'] = 'Error saat upload file: ' . $this->getUploadErrorMessage($file['error']);
            return $result;
        }
        
        // Cek ukuran file
        if ($file['size'] > $maxSize) {
            $result['message'] = 'Ukuran file terlalu besar (maksimum 2MB)';
            return $result;
        }
        
        // Cek ekstensi file
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension']);
        
        if (!in_array($extension, $allowedExtensions)) {
            $result['message'] = 'Format file tidak diizinkan. Format yang diizinkan: ' . implode(', ', $allowedExtensions);
            return $result;
        }
        
        // Tentukan folder upload
        $uploadDir = 'assets/images/';
        
        // Buat folder jika belum ada
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate nama file unik
        $fileName = $type . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $fileName;
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $result['success'] = true;
            $result['message'] = 'File berhasil diupload';
            $result['path'] = $targetPath;
        } else {
            $result['message'] = 'Gagal mengupload file';
        }
        
        return $result;
    }
    
    /**
     * Get upload error message
     * 
     * @param int $errorCode Error code dari $_FILES['error']
     * @return string Pesan error yang user-friendly
     */
    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'Ukuran file melebihi batas maksimum yang diizinkan oleh server';
            case UPLOAD_ERR_FORM_SIZE:
                return 'Ukuran file melebihi batas maksimum yang diizinkan oleh form';
            case UPLOAD_ERR_PARTIAL:
                return 'File hanya terupload sebagian';
            case UPLOAD_ERR_NO_FILE:
                return 'Tidak ada file yang diupload';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Folder temporary tidak tersedia';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Gagal menyimpan file ke disk';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload dihentikan oleh ekstensi PHP';
            default:
                return 'Error upload tidak diketahui';
        }
    }
} 