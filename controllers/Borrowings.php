<?php
namespace Controllers;
use Models\Model as Model;
//use Models\Comments as ModelBorrowings;
class Borrowings extends Controller {
    private $model = null;
    private $modelBorrowings = null;
    public  function __construct()
    {
        $this->model = new Model();
        //$this->$modelBorrowings = new ModelBorrowings();
    }

    public function list() {

    }

    public function add() {

    }

    public function added() {

    }
}
