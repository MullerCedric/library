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
        $books = $this->modelBooks->getBooks();
        return ['view' => 'views/books.php',
            'booksList' => $books];
    }

    public function zoom()
    {
        if( !isset( $_GET['id'] ) OR intval( $_GET['id'], 10) < 1 ) {
            $_SESSION['error'][] = 'Paramètre invalide';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=list' );
            exit;
        }
        $book = $this->modelBooks->getBook( $_GET['id'] );
        $book_versions = $this->modelBooks->getBookVersions( $_GET['id'] );
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

        $books_id = $this->modelBooks->addBook([
            'title' => trim($_POST['title']),
            'synopsis' => $synopsis,
            'tags' => $tags,
            'authors_id' => $_POST['authors_id'],
            'series_id' => $series_id,
            'genres_id' => $_POST['genres_id']
        ]);

        if($books_id){
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

        if (!$this->modelBooks->isAValidString($_POST['isbn']) OR
            !$this->modelBooks->isAValidString($_POST['publication']) OR
            !$this->modelBooks->isAValidString($_POST['lang']) OR
            !$this->modelBooks->isAValidPosInt($_POST['page_number']) OR
            !$this->modelBooks->isAValidPosInt($_POST['copies']) OR
            !$this->modelBooks->isAValidPosInt($books_id)
        ) {
            $_SESSION['error'][] = $_POST;
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'ajout de la version a échoué !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=books&a=add');
            exit;
        }
        $cover = $_POST['cover'] ? $this->modelBooks->checkCoverURL($_POST['cover']) : null;
        $description = $_POST['description'] ? trim($_POST['description']) : null;

        $this->modelBooks->addVersion([
            'ISBN' => trim($_POST['isbn']),
            'publication' => trim($_POST['publication']),
            'cover' => $cover,
            'lang' => trim($_POST['lang']),
            'copies' => $_POST['copies'],
            'description' => $description,
            'page_number' => $_POST['page_number'],
            'books_id' => $books_id
        ]);

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

    }

    public function edited()
    {

    }
}
