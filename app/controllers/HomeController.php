<?php
namespace controllers;

use core\Controller;

/**
 * Home Controller
 * 
 * Controller untuk halaman utama
 */
class HomeController extends Controller
{
    /**
     * Constructor
     * Load dependency
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Halaman home
     * 
     * @return void
     */
    public function index()
    {
        // Cek jika user sudah login, redirect ke dashboard
        if ($this->session->has('user_id')) {
            if ($this->session->get('user_role') === 'admin') {
                $this->redirect('dashboard');
            } else {
                $this->redirect('dashboard');
            }
        } else {
            // Jika belum login, redirect ke halaman login
            $this->redirect('auth');
        }
    }
} 