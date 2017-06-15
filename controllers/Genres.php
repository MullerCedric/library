<?php
namespace Controllers;
use Models\Model as Model;
//use Models\Comments as ModelGenres;
class Genres extends Controller {
    private $model = null;
    private $modelGenres = null;
    public  function __construct()
    {
        $this->model = new Model();
        //$this->$modelGenres = new ModelGenres();
    }

    public function list() {

    }

    public function add() {

    }

    public function added() {

    }
}
