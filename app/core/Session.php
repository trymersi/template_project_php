<?php
namespace core;

/**
 * Session Class
 * 
 * Class untuk menangani session
 */
class Session
{
    /**
     * Constructor
     * Set session lifetime dan mulai session
     */
    public function __construct()
    {
        // Cek jika session belum dimulai
        if (session_status() === PHP_SESSION_NONE) {
            // Set session cookie parameters
            session_set_cookie_params([
                'lifetime' => SESSION_LIFETIME, 
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            
            // Set session name
            session_name(SESSION_NAME);
            
            // Start session
            session_start();
        }
        
        // Set session sesuai lifetime
        $this->checkSessionLifetime();
    }
    
    /**
     * Set session value
     * 
     * @param string $key Key session
     * @param mixed $value Value session
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session value
     * 
     * @param string $key Key session
     * @return mixed Value session
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }
    
    /**
     * Check if session key exists
     * 
     * @param string $key Key session
     * @return bool True jika session ada, false jika tidak
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session key
     * 
     * @param string $key Key session
     * @return void
     */
    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Set flash message
     * 
     * @param string $key Key flash message
     * @param mixed $value Value flash message
     * @return void
     */
    public function setFlash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }
    
    /**
     * Get flash message
     * 
     * @param string $key Key flash message
     * @return mixed Value flash message
     */
    public function getFlash($key)
    {
        $message = $_SESSION['_flash'][$key] ?? null;
        
        if (isset($_SESSION['_flash'][$key])) {
            unset($_SESSION['_flash'][$key]);
        }
        
        return $message;
    }
    
    /**
     * Check if flash message exists
     * 
     * @param string $key Key flash message
     * @return bool True jika flash message ada, false jika tidak
     */
    public function hasFlash($key)
    {
        return isset($_SESSION['_flash'][$key]);
    }
    
    /**
     * Destroy session
     * 
     * @return void
     */
    public function destroy()
    {
        // Unset all session variables
        $_SESSION = [];
        
        // Expire cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        // Destroy session
        session_destroy();
    }
    
    /**
     * Regenerate session ID
     * 
     * @param bool $deleteOldSession Delete old session data
     * @return bool True jika berhasil, false jika gagal
     */
    public function regenerate($deleteOldSession = true)
    {
        return session_regenerate_id($deleteOldSession);
    }
    
    /**
     * Check session lifetime
     * 
     * @return void
     */
    private function checkSessionLifetime()
    {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
            $this->destroy();
        }
        
        $_SESSION['last_activity'] = time();
    }
} 