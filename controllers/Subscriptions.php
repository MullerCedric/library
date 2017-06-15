<?php
namespace Controllers;
use Models\Model as Model;
//use Models\Comments as ModelSubscriptions;
class Subscriptions extends Controller {
    private $model = null;
    private $modelSubscriptions = null;
    public  function __construct()
    {
        $this->model = new Model();
        //$this->$modelSubscriptions = new ModelSubscriptions();
    }

    public function add() {

    }

    public function added() {

    }
}
