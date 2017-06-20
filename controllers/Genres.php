<?php
namespace Controllers;
use Models\Model as Model;
use Models\Genres as ModelGenres;
class Genres extends Controller {
    private $model = null;
    private $modelGenres = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelGenres = new ModelGenres();
    }

    public function list() {
        $order = $_GET['order'] ?? null;
        $genres = $this->modelGenres->getGenres( $order );
        return ['view' => 'views/genres.php',
        'genresList' => $genres ];
    }

    public function add() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        return ['view' => 'views/addGenre.php'];
    }

    public function added() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        if ( empty( $_POST['name'] ) ) {
            $_SESSION['error'][] = 'Merci de saisir des données complètes';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=genres&a=add' );
            exit;
        }

        if ( $this->modelGenres->addGenre( $_POST['name'] ) ) {
            $_SESSION['success'][] = 'Le nouveau genre a bien été ajouté !';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Le nouveau genre n\'a pas été ajouté';
        }
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=genres&a=add' );
        exit;
    }
}
