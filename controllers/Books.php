<?php
namespace Controllers;
use Models\Model as Model;
use Models\Books as ModelBooks;
class Books extends Controller {
    private $model = null;
    private $modelAuthors = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelBooks = new ModelBooks();
    }

    public function list() {

    }

    public function zoom() {

    }

    public function add() {
        if ( !$this->is_connected() OR !$this->model->is_admin( $_SESSION['user']['id'], $_SESSION['user']['password'] ) ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }

        return [ 'view' => 'views/addBook.php' ];
    }

    public function added() {

    }

    public function edit() {

    }

    public function edited() {

    }
}
