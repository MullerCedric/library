<?php
namespace Controllers;

use Models\Books as ModelBooks;
use Models\Authors as ModelAuthors;
use Models\Genres as ModelGenres;
use Models\Borrowings as ModelBorrowings;

class Books extends Controller
{
    private $modelBooks = null;
    private $modelAuthors = null;
    private $modelGenres = null;
    private $modelBorrowings = null;

    public function __construct()
    {
        $this->modelBooks = new ModelBooks();
        $this->modelAuthors = new ModelAuthors();
        $this->modelGenres = new ModelGenres();
        $this->modelBorrowings = new ModelBorrowings();
    }

    public function list()
    {
        $order = $_GET['order'] ?? null;
        if ( isset( $_GET['filter'] ) && intval( $_GET['filter'], 10 ) > 0 ) {
            $books = $this->modelBooks->getBooks( $order, $_GET['filter'] );
        } else {
            $books = $this->modelBooks->getBooks( $order );
        }
        return ['view' => 'views/books.php',
            'booksList' => $books];
    }

    public function zoom()
    {
        $id = 1;
        if( isset( $_GET['id'] ) || isset( $_GET['isbn'] ) ) {
            if ( isset( $_GET['id'] ) ) {
                if ( intval( $_GET['id'], 10) < 1 ) {
                    $_SESSION['error'][] = 'Paramètre invalide';
                    header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
                    exit;
                }
                $id = $_GET['id'];
            }
            if ( isset( $_GET['isbn'] )) {
                if( strlen( $_GET['isbn'] ) < 10 ) {
                    $_SESSION['error'][] = 'Paramètre invalide';
                    header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
                    exit;
                }
                if ( ! $id = $this->modelBooks->getBookIdFromISBN( urldecode( $_GET['isbn'] ) )->bookId ) {
                    $_SESSION['error'][] = 'Aucun livre ne correspond à cet ISBN';
                    header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
                    exit;
                }
            }
        } else {
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
            exit;
        }
        $book = $this->modelBooks->getBook( $id );
        $book_versions = $this->modelBooks->getBookVersions( $id );
        foreach ($book_versions as $version){
            if ( $version->copies <= $this->modelBorrowings->countCopiesBorrowed( $version->ISBN )->nbBorrowings ) {
                $version->hasCopiesLeft = false;
            } else {
                $version->hasCopiesLeft = true;
            }
        }
        return [ 'view' => 'views/book.php',
            'book' => $book,
            'book_versions' => $book_versions];
    }

    public function add()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        return ['view' => 'views/addBook.php',
            'authorsList' => $this->modelAuthors->getAuthors(),
            'genresList' => $this->modelGenres->getGenres()];
    }

    public function added()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        if (!$this->modelBooks->isAValidString($_POST['title']) OR
            !$this->modelBooks->isAValidPosInt($_POST['authors_id']) OR
            !$this->modelBooks->isAValidPosInt($_POST['genres_id'])
        ) {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'ajout du livre a échoué !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=add');
            exit;
        }

        $synopsis = $_POST['synopsis'] ? trim($_POST['synopsis']) : null;
        $tags = $_POST['tags'] ? trim($_POST['tags']) : null;
        $series_id = $_POST['series_id'] ? $this->modelBooks->checkId($_POST['series_id']) : null;

        if ( $books_id = $this->modelBooks->addBook([
            'title' => trim($_POST['title']),
            'synopsis' => $synopsis,
            'tags' => $tags,
            'authors_id' => $_POST['authors_id'],
            'series_id' => $series_id,
            'genres_id' => $_POST['genres_id']
        ]) ) {
            $_SESSION['success'][] = 'Livre ajouté !';
            $this->addedVersion($books_id);
        }else{
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. L\'ajout du livre a échoué !';
        }
    }

    public function addVersion()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        $books = $this->modelBooks->getBooks();
        foreach ($books as $book){
            if( isset( $_GET['id'] ) && $book->id == $_GET['id'] ) {
                $book->selected = true;
            } else {
                $book->selected = false;
            }
        }
        return ['view' => 'views/addVersion.php',
            'booksList' => $books];
    }

    public function addedVersion($books_id = null)
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        $books_id = $_POST['books_id'] ?? $books_id;

        if ( !isset( $_POST['isbn'] ) || !$this->modelBooks->isAValidString($_POST['isbn']) ) {
            $_SESSION['error'][] = 'Un ISBN contient au moins 10 caractères';
        }
        if ( !isset( $_POST['publication'] ) || !$this->modelBooks->isAValidString($_POST['publication']) ) {
            $_SESSION['error'][] = 'Le champ "publication" n\'a pas été remplis correctement';
        }
        if ( !isset( $_POST['lang'] ) || !$this->modelBooks->isAValidString($_POST['lang']) ) {
            $_SESSION['error'][] = 'Le champ "langue" n\'a pas été remplis correctement';
        }
        if ( !isset( $_POST['page_number'] ) || !$this->modelBooks->isAValidPosInt($_POST['page_number']) ) {
            $_SESSION['error'][] = 'Le nombre de pages n\'a pas été correctement renseigné';
        }
        if ( !isset( $_POST['copies'] ) || !$this->modelBooks->isAValidPosInt($_POST['copies']) ){
            $_SESSION['error'][] = 'Le nombre de copies n\'a pas été correctement renseigné';
        }
        if ( !$this->modelBooks->isAValidPosInt($books_id) ) {
            $_SESSION['error'][] = 'Le livre auquel ajouter la version n\'est pas correct';
        }
        if ( isset( $_SESSION['error'] ) ) {
            $_SESSION['error'][] = 'L\'ajout de la version a échoué !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=addVersion');
            exit;
        }
        if ( isset( $_POST['cover'] ) ) {
            if ( ! $cover = preg_match( '#(\.jpg|\.jpeg|\.png)$#', $_POST['cover'] ) ) {
                $_SESSION['warning'][] = 'La photo fournie n\'était pas au bon format. Elle a donc été ignorée';
            }
        } else {
            $cover = null;
        }
        $description = $_POST['description'] ? trim($_POST['description']) : null;

        if ( $this->modelBooks->addVersion([
            'ISBN' => trim($_POST['isbn']),
            'publication' => trim($_POST['publication']),
            'cover' => $cover,
            'lang' => trim($_POST['lang']),
            'copies' => $_POST['copies'],
            'description' => $description,
            'page_number' => $_POST['page_number'],
            'books_id' => $books_id
        ]) ) {
            $_SESSION['success'][] = 'Version ajoutéé !';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. L\'ajout de la version a échoué !';
        }

        header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=add');
        exit;
    }

    public function addedCopy()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=list');
            exit;
        }
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
        if( !$_SESSION['error'] && $this->modelBooks->addCopy( urldecode( $_GET['isbn'] ) ) ) {
            $_SESSION['success'][] = 'Une copie a bien été ajoutée';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. La copie n\'a pas été ajoutée !';
        }
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
        exit;
    }

    public function edit()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        if ( isset( $_GET['id'] ) && intval( $_GET['id'], 10) < 1 ) {
            $_SESSION['error'][] = 'Paramètre invalide';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
            exit;
        }
        $book = $this->modelBooks->getBook( $_GET['id'] );
        $book_versions = $this->modelBooks->getBookVersions( $_GET['id'] );
        return [ 'view' => 'views/editBook.php',
            'book' => $book,
            'book_versions' => $book_versions,
            'authorsList' => $this->modelAuthors->getAuthors(),
            'genresList' => $this->modelGenres->getGenres()];
    }

    public function edited()
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        if (!$this->modelBooks->isAValidString($_POST['title']) OR
            !$this->modelBooks->isAValidPosInt($_POST['authors_id']) OR
            !$this->modelBooks->isAValidPosInt($_POST['genres_id']) OR
            !$this->modelBooks->isAValidPosInt($_POST['id'])
        ) {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). Le livre n\'a pas été édité !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=list');
            exit;
        }

        $synopsis = $_POST['synopsis'] ? trim($_POST['synopsis']) : null;
        $tags = $_POST['tags'] ? trim($_POST['tags']) : null;
        $series_id = $_POST['series_id'] ? $this->modelBooks->checkId($_POST['series_id']) : null;

        if ( $books_id = $this->modelBooks->editBook([
            'title' => trim($_POST['title']),
            'synopsis' => $synopsis,
            'tags' => $tags,
            'authors_id' => $_POST['authors_id'],
            'series_id' => $series_id,
            'genres_id' => $_POST['genres_id'],
            'id' => $_POST['id']
        ]) ) {
            $_SESSION['success'][] = 'Le livre a été édité';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=zoom&id=' . $_POST['id'] );
            exit;
        }else{
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Le livre n\'a pas été édité !';header( 'Location: ' .                    HARDCODED_URL . 'index.php?r=books&a=zoom&id=' . $_POST['id'] );
            exit;
        }
    }
}
