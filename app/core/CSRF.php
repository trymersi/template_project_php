<?php
namespace core;

/**
 * CSRF Protection Class
 * 
 * Class untuk proteksi Cross-Site Request Forgery (CSRF)
 */
class CSRF
{
    /**
     * Generate CSRF token baru
     * 
     * @return string CSRF token
     */
    public function generateToken()
    {
        $token = bin2hex(random_bytes(CSRF_TOKEN_LENGTH / 2));
        $_SESSION[CSRF_TOKEN_NAME] = $token;
        return $token;
    }
    
    /**
     * Verifikasi CSRF token
     * 
     * @return bool True jika valid, false jika tidak
     */
    public function verifyToken()
    {
        // Cek apakah token ada di session
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            // Debug: catat bahwa tidak ada token di sesi
            error_log('CSRF Verification Failed: No token in session');
            return false;
        }
        
        // Ambil token dari POST atau header request
        $token = $this->getRequestToken();
        
        // Debug: catat token yang diterima
        error_log('CSRF Token Received: ' . ($token ?: 'none') . ', Session Token: ' . $_SESSION[CSRF_TOKEN_NAME]);
        
        // Cek apakah token valid
        if (!$token) {
            error_log('CSRF Verification Failed: No token in request');
            return false;
        }
        
        // Bandingkan token dengan case insensitive
        if (strcasecmp($token, $_SESSION[CSRF_TOKEN_NAME]) !== 0) {
            error_log('CSRF Verification Failed: Tokens do not match');
            return false;
        }
        
        // Token valid, regenerate token untuk request berikutnya
        $this->regenerateToken();
        
        return true;
    }
    
    /**
     * Regenerate CSRF token
     * 
     * @return string Token baru
     */
    public function regenerateToken()
    {
        return $this->generateToken();
    }
    
    /**
     * Get token dari request
     * 
     * @return string|null Token dari request
     */
    private function getRequestToken()
    {
        // Cek dari POST
        if (isset($_POST[CSRF_TOKEN_NAME])) {
            return $_POST[CSRF_TOKEN_NAME];
        }
        
        // Cek dari X-CSRF-Token header
        $headers = $this->getAllHeaders();
        
        // Periksa header dengan case insensitive
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'x-csrf-token') {
                return $value;
            }
        }
        
        return null;
    }
    
    /**
     * Get all headers cross-platform
     * 
     * @return array All HTTP headers
     */
    private function getAllHeaders()
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }
        
        // Fallback untuk server yang tidak mendukung getallheaders()
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                $headerKey = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$headerKey] = $value;
            } else if ($name === 'CONTENT_TYPE' || $name === 'CONTENT_LENGTH') {
                $headerKey = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $name))));
                $headers[$headerKey] = $value;
            }
        }
        
        return $headers;
    }
    
    /**
     * Get HTML input field dengan CSRF token
     * 
     * @return string HTML input field
     */
    public function getTokenField()
    {
        // Generate token jika belum ada
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $this->generateToken();
        }
        
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $_SESSION[CSRF_TOKEN_NAME] . '">';
    }
} 