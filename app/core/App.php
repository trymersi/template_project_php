<?php
namespace core;

/**
 * Class App
 * 
 * Router utama aplikasi yang menangani request URL dan memanggil controller yang sesuai
 */
class App
{
    // Default controller, method, dan parameter
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    /**
     * Constructor
     * Menginisialisasi router dan memanggil controller yang sesuai
     */
    public function __construct()
    {
        $url = $this->parseUrl();
        
        // Cek apakah controller ada
        if (isset($url[0]) && file_exists('app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }
        
        // Load controller
        $this->controller = $this->controller . 'Controller';
        $controllerClass = '\\controllers\\' . $this->controller;
        $this->controller = new $controllerClass;
        
        // Cek apakah method ada di controller
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        // Ambil parameter
        $this->params = $url ? array_values($url) : [];
        
        // Panggil controller, method, dan parameter
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse URL menjadi array
     * 
     * @return array URL yang sudah di-parse
     */
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            // Bersihkan URL dari trailing slash, filter karakter berbahaya, dan split menjadi array
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        
        return [];
    }
} 