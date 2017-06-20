<?php
namespace Controllers;


class Page extends Controller
{

    public function index()
    {
        if ($this->is_connected()) {
            header('Location: ' . HARDCODED_URL . 'index.php?r=page&a=dashboard');
            exit;
        }
        return ['view' => 'views/homePage.php',
            'title' => 'Accueil'];
    }

    public function dashboard()
    {
        return ['view' => 'views/dashboard.php',
            'title' => 'Dashboard'];
    }
}
