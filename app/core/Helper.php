<?php
namespace core;

/**
 * Helper functions
 * 
 * Kumpulan fungsi pembantu yang sering digunakan
 */
class Helper
{
    /**
     * Sanitize input data
     * 
     * @param mixed $data Data yang akan disanitasi
     * @return mixed Data yang sudah disanitasi
     */
    public static function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }
        
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Format harga menjadi format rupiah
     * 
     * @param float $amount Jumlah uang
     * @return string Uang dalam format rupiah
     */
    public static function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    
    /**
     * Format tanggal ke format Indonesia
     * 
     * @param string $date Tanggal
     * @param bool $withTime Tampilkan dengan waktu
     * @return string Tanggal dalam format Indonesia
     */
    public static function formatDate($date, $withTime = false)
    {
        $dateObj = new \DateTime($date);
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $day = $dateObj->format('d');
        $month = $months[$dateObj->format('n') - 1];
        $year = $dateObj->format('Y');
        
        $formattedDate = "$day $month $year";
        
        if ($withTime) {
            $time = $dateObj->format('H:i');
            $formattedDate .= " $time";
        }
        
        return $formattedDate;
    }
    
    /**
     * Generate random string
     * 
     * @param int $length Panjang string
     * @return string Random string
     */
    public static function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
    
    /**
     * Redirect ke URL tertentu
     * 
     * @param string $url URL tujuan
     * @return void
     */
    public static function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Check apakah request adalah AJAX
     * 
     * @return bool True jika AJAX, false jika tidak
     */
    public static function isAjax()
    {
        // Cek header standar
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        }
        
        // Cek header khusus
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = strtolower(str_replace('HTTP_', '', $key));
                // Cek beberapa header yang biasa digunakan untuk Ajax
                if ($header === 'x_requested_with' && strtolower($value) === 'xmlhttprequest') {
                    return true;
                }
            }
        }
        
        // Cek jika request menerima respons JSON (biasanya menunjukkan Ajax)
        $acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';
        if (strpos($acceptHeader, 'application/json') !== false) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get URL saat ini
     * 
     * @return string URL saat ini
     */
    public static function currentUrl()
    {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        
        return "$protocol://$host$uri";
    }
    
    /**
     * Hash password menggunakan password_hash
     * 
     * @param string $password Password
     * @return string Hashed password
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verifikasi password
     * 
     * @param string $password Password
     * @param string $hash Hashed password
     * @return bool True jika cocok, false jika tidak
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
} 