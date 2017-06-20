<?php
namespace Controllers;
use Models\Model as Model;
use Models\Page as ModelPage;
class Page extends Controller {
    private $model = null;
    private $modelPage = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelPage = new ModelPage();
    }

    public function index() {
        if ( $this->is_connected() ) {
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=page&a=dashboard' );
            exit;
        }
        return [ 'view' => 'views/homePage.php',
            'title' => 'Accueil' ];
    }

    public function dashboard() {
        return [ 'view' => 'views/dashboard.php',
            'title' => 'Dashboard' ];
    }
}
