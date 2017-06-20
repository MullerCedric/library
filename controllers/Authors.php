<?php
namespace Controllers;
use Models\Authors as ModelAuthors;
use Models\Books as ModelBooks;
class Authors extends Controller {
    private $modelAuthors = null;
    private $modelBooks = null;
    public  function __construct()
    {
        $this->modelAuthors = new ModelAuthors();
        $this->modelBooks = new ModelBooks();
    }

    public function list() {
        $authors = $this->modelAuthors->getAuthors();
        return ['view' => 'views/authors.php',
            'authorsList' => $authors ];
    }

    public function zoom() {
        if( !isset( $_GET['id'] ) OR intval( $_GET['id'], 10) < 1 ) {
            $_SESSION['error'][] = 'Paramètre invalide';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=authors&a=list' );
            exit;
        }
        $author = $this->modelAuthors->getAuthor( $_GET['id'] );
        $books = $this->modelBooks->getBooksFromAuthor( $_GET['id'] );
        return [ 'view' => 'views/author.php',
            'author' => $author,
            'books' => $books];
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
        if ( isset( $_POST['birth_date'] ) ) {
            if ( ! $birthDate = $this->modelAuthors->checkBirthDate( $_POST['birth_date'] ) ) {
                $_SESSION['warning'][] = 'La date fournie n\'était pas au bon format. Elle a donc été ignorée';
            }
        } else {
            $birthDate = null;
        }
        if ( isset( $_POST['picture'] ) ) {
            if ( ! $picture = preg_match( '#(\.jpg|\.jpeg|\.png)$#', $_POST['picture'] ) ) {
                $_SESSION['warning'][] = 'La photo fournie n\'était pas au bon format. Elle a donc été ignorée';
            }
        } else {
            $picture = null;
        }
        $description = $_POST['description'] ?? null;

        if ( $this->modelAuthors->addAuthor( [
            'alias_name' => trim( $_POST['name'] ),
            'birth_date' => $birthDate,
            'picture' => $picture,
            'description' => $description
        ] ) ) {
            $_SESSION['success'][] = 'Le nouvel auteur a bien été ajouté !';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Le nouvel auteur n\'a pas été ajouté';
        }

        header( 'Location: ' . HARDCODED_URL . 'index.php?r=authors&a=add' );
        exit;
    }

    public function edit() {

    }

    public function edited() {

    }
}
