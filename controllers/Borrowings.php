<?php
namespace Controllers;
use Models\Model as Model;
use Models\Borrowings as ModelBorrowings;
use Models\Books as ModelBooks;
use Models\Subscriptions as ModelSubscriptions;
class Borrowings extends Controller {
    private $model = null;
    private $modelBorrowings = null;
    private $modelBooks = null;
    private $modelSubscriptions = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelBorrowings = new ModelBorrowings();
        $this->modelBooks = new ModelBooks();
        $this->modelSubscriptions = new ModelSubscriptions();
    }

    public function list() {
        if( !$this->is_connected() ) {
            $_SESSION['error'][] = 'Vous devez être connecté pour accéder à cette page';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=user&a=logIn' );
            exit;
        }
        if ( ! $borrowings = $this->modelBorrowings->getBooksBorrowed( $_SESSION['user']->bar_code ) ) {
            $borrowings = null;
        }
        return ['view' => 'views/borrowings.php',
            'title' => 'Liste des emprunts',
            'borrowings' => $borrowings ];
    }

    public function added() {
        if( !isset($_GET['isbn']) ) {
            $_SESSION['error'][] = 'Paramètre invalide';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
            exit;
        }
        if( ! $version = $this->modelBooks->getVersion( urldecode( $_GET['isbn'] ) ) ) {
            $_SESSION['error'][] = 'Le livre demandé n\'a pas été trouvé';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
            exit;
        }
        if( !$this->is_connected() ) {
            $_SESSION['error'][] = 'Vous devez être connecté pour pouvoir réserver un livre';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=zoom&isbn=' . $_GET['isbn'] );
            exit;
        }
        if( !$this->modelSubscriptions->getActiveSubscription( $_SESSION['user']->bar_code ) ) {
            $_SESSION['error'][] = 'Vous devez être abonné pour pouvoir réserver un livre. Pour vous abonner, merci de vous rendre à la bibliothèque (6€/an)';
        }
        if( $version->copies <= $this->modelBorrowings->countCopiesBorrowed( urldecode( $_GET['isbn'] ) )->nbBorrowings ) {
            $_SESSION['error'][] = 'Désolé mais tous les exemplaires de ce livre ont été réservé. Vérifié si une autre version du livre est disponible ou choisissez un autre livre parmi notre large sélection';
        }
        if( MAX_BORROWED_BOOKS <= $this->modelBorrowings->countBooksBorrowed( $_SESSION['user']->bar_code )->nbBorrowings ) {
            $_SESSION['error'][] = 'Vous avez atteint votre limite de réservation de livres';
        }
        if( !$_SESSION['error'] && $this->modelBorrowings->addBorrowing( $_SESSION['user']->bar_code, urldecode( $_GET['isbn'] ) ) ) {
            $_SESSION['success'][] = 'Le livre a bien été réservé';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Le livre n\'a pas été réservé !';
        }
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=zoom&isbn=' . $_GET['isbn'] );
        exit;
    }
}
