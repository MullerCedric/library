<?php
namespace Controllers;
use Models\Model as Model;
use Models\Authors as ModelAuthors;
class Authors extends Controller {
    private $model = null;
    private $modelAuthors = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelAuthors = new ModelAuthors();
    }

    public function list() {
        return [ 'view' => 'views/authors.php' ];
    }

    public function zoom() {
        return [ 'view' => 'views/author.php' ];
    }

    public function add() {

    }

    public function added() {

    }

    public function edit() {

    }

    public function edited() {

    }
}
