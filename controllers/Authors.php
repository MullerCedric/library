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
        $authors = $this->modelAuthors->getAuthors();
        return ['view' => 'views/authors.php',
            'authorsList' => $authors ];
    }

    public function zoom() {
        return [ 'view' => 'views/author.php' ];
    }

    public function add() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        return ['view' => 'views/addAuthor.php'];
    }

    public function added() {
        if( empty( trim( $_POST['name'] ) ) ) {
            $_SESSION['error'][] = 'Veuillez saisir le nom de l\'auteur';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=authors&a=add' );
            exit;
        }
        $birthDate = $_POST['birth_date'] ? $this->modelAuthors->checkBirthDate( $_POST['birth_date'] ) : null;
        $picture = $_POST['picture'] ? $this->modelAuthors->checkPictureURL( $_POST['picture'] ) : null;
        $description = $_POST['description'] ?? null;

        $this->modelAuthors->addAuthor( [
            'alias_name' => trim( $_POST['name'] ),
            'birth_date' => $birthDate,
            'picture' => $picture,
            'description' => $description
        ] );

        header( 'Location: ' . HARDCODED_URL . 'index.php?r=authors&a=add' );
        exit;
    }

    public function edit() {

    }

    public function edited() {

    }
}
