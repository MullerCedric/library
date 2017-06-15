<?php
namespace Controllers;
use Models\Model as Model;
use Models\Comments as ModelComments;
class Comments extends Controller {
    private $model = null;
    private $modelComments = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelComments = new ModelComments();
    }

    public function added() {

    }

    public function edit() {

    }

    public function edited() {

    }

    public function moderate() {

    }
}
