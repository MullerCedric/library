<?php
namespace Controllers;
use Models\Books as ModelBooks;
use Models\Authors as ModelAuthors;
use Models\Genres as ModelGenres;
class Books extends Controller {
    private $modelBooks = null;
    private $modelAuthors = null;
    private $modelGenres = null;
    public  function __construct()
    {
        $this->modelBooks = new ModelBooks();
        $this->modelAuthors = new ModelAuthors();
        $this->modelGenres = new ModelGenres();
    }

    public function list() {
        $books = $this->modelBooks->getBooks();
        return ['view' => 'views/books.php',
            'booksList' => $books ];
    }

    public function zoom() {

    }

    public function add() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }

        return [ 'view' => 'views/addBook.php',
            'authorsList' => $this->modelAuthors->getAuthors(),
            'genresList' => $this->modelGenres->getGenres() ];
    }

    public function added() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }

        if( !$this->modelBooks->isAValidString( $_POST['title'] ) OR
            !$this->modelBooks->isAValidPosInt( $_POST['authors_id'] ) OR
            !$this->modelBooks->isAValidPosInt( $_POST['genres_id'] ) ) {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'ajout du livre a échoué !';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=add' );
            exit;
        }

        $synopsis = $_POST['synopsis'] ? trim( $_POST['synopsis'] ) : null;
        $tags = $_POST['tags'] ? trim( $_POST['tags'] ) : null;
        $series_id = $_POST['series_id'] ? $this->modelBooks->checkId( $_POST['series_id'] ) : null;

        $this->modelBooks->addBook( [
            'title' => trim( $_POST['title'] ),
            'synopsis' => $synopsis,
            'tags' => $tags,
            'authors_id' => $_POST['authors_id'],
            'series_id' => $series_id,
            'genres_id' => $_POST['genres_id']
        ] );

        $bookVersion = [
            'isbn' => $_POST['isbn'] ?? null,
            'publication' => $_POST['publication'] ?? null,
            'cover' => $_POST['cover'] ?? null,
            'lang' => $_POST['lang'] ?? null,
            'copies' => $_POST['copies'] ?? null,
            'description' => $_POST['description'] ?? null,
            'page_number' => $_POST['page_number'] ?? null,
        ];

        $_SESSION['bookVersion'] = $bookVersion;
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=addedVersion' );
        exit;
    }

    public function addVersion() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }

        return [ 'view' => 'views/addVersion.php' ];
    }

    public function addedVersion() {
        if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']->is_admin ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }

        if( isset( $_SESSION['bookVersion'] ) ) {
            if( !$this->modelBooks->isAValidString( $_SESSION['bookVersion']['isbn'] ) OR
                !$this->modelBooks->isAValidString( $_SESSION['bookVersion']['publication'] ) OR
                !$this->modelBooks->isAValidString( $_SESSION['bookVersion']['lang'] ) OR
                !$this->modelBooks->isAValidPosInt( $_SESSION['bookVersion']['page_number'] ) OR
                !$this->modelBooks->isAValidPosInt( $_SESSION['bookVersion']['copies'] ) OR
                !$this->modelBooks->isAValidPosInt( $_SESSION['bookVersion']['books_id'] ) ) {
                $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'ajout de la version a échoué !';
                header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=add' );
                exit;
            }
            $cover = $_SESSION['bookVersion']['cover'] ? $this->modelBooks->checkCoverURL( $_SESSION['bookVersion']['cover'] ) : null;
            $description = $_SESSION['bookVersion']['description'] ? trim( $_SESSION['bookVersion']['description'] ) : null;

            $this->modelBooks->addVersion( [
                'ISBN' => trim( $_SESSION['bookVersion']['isbn'] ),
                'publication' => trim( $_SESSION['bookVersion']['publication'] ),
                'cover' => $cover,
                'lang' => trim( $_SESSION['bookVersion']['lang'] ),
                'copies' => $_SESSION['bookVersion']['copies'],
                'description' => $description,
                'page_number' => $_SESSION['bookVersion']['page_number'],
                'books_id' => $_SESSION['bookVersion']['books_id']
            ] );
        } elseif ( isset( $_POST['isbn'] ) ) {
            if( !$this->modelBooks->isAValidString( $_POST['isbn'] ) OR
                !$this->modelBooks->isAValidString( $_POST['publication'] ) OR
                !$this->modelBooks->isAValidString( $_POST['lang'] ) OR
                !$this->modelBooks->isAValidPosInt( $_POST['page_number'] ) OR
                !$this->modelBooks->isAValidPosInt( $_POST['copies'] ) OR
                !$this->modelBooks->isAValidPosInt( $_POST['books_id'] ) ) {
                $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'ajout de la version a échoué !';
                header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=add' );
                exit;
            }
            $cover = $_POST['cover'] ? $this->modelBooks->checkCoverURL( $_POST['cover'] ) : null;
            $description = $_POST['description'] ? trim( $_POST['description'] ) : null;

            $this->modelBooks->addVersion( [
                'ISBN' => trim( $_POST['isbn'] ),
                'publication' => trim( $_POST['publication'] ),
                'cover' => $cover,
                'lang' => trim( $_POST['lang'] ),
                'copies' => $_POST['copies'],
                'description' => $description,
                'page_number' => $_POST['page_number'],
                'books_id' => $_POST['books_id']
            ] );
        } else {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). La version du livre n\'a pas été ajoutée !';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=addVersion' );
            exit;
        }

        $_SESSION['bookVersion'] = [];
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=books&a=add' );
        exit;
    }

    public function edit() {

    }

    public function edited() {

    }
}
