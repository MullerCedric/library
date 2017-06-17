<?php
namespace Controllers;

use Models\Books as ModelBooks;
use Models\Authors as ModelAuthors;
use Models\Genres as ModelGenres;

class Books extends Controller
{
    private $modelBooks = null;
    private $modelAuthors = null;
    private $modelGenres = null;

    public function __construct()
    {
        $this->modelBooks = new ModelBooks();
        $this->modelAuthors = new ModelAuthors();
        $this->modelGenres = new ModelGenres();
    }

    public function list()
    {
        $books = $this->modelBooks->getBooks();
        return ['view' => 'views/books.php',
            'booksList' => $books];
    }

    public function zoom()
    {

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

    public function edit()
    {

    }

    public function edited()
    {

    }
}
