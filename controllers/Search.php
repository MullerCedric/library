<?php
namespace Controllers;

use Models\Authors as ModelAuthors;
use Models\Books as ModelBooks;
use Models\Genres as ModelGenres;

class Search extends Controller
{
    private $modelAuthors = null;
    private $modelBooks = null;
    private $modelGenres = null;

    public function __construct()
    {
        $this->modelAuthors = new ModelAuthors();
        $this->modelBooks = new ModelBooks();
        $this->modelGenres = new ModelGenres();
    }

    public function find()
    {
        if (!isset($_GET['type']) OR !isset($_GET['q']) OR
            strlen($_GET['type']) < 1 OR strlen($_GET['q']) < 1
        ) {
            $_SESSION['error'][] = 'Les paramètres de la recherche sont erronés';
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        $found = null;
        $type = null;
        switch ($_GET['type']) {
            case "author":
                if ($found = $this->modelAuthors->findAuthor($_GET['q'])) {
                    $type = $_GET['type'];
                }
                break;
            case "book":
                if ($found = $this->modelBooks->findBook($_GET['q'])) {
                    $type = $_GET['type'];
                }
                break;
            case "genre":
                if ($found = $this->modelGenres->findGenre($_GET['q'])) {
                    $type = $_GET['type'];
                }
                break;
        }

        return ['view' => 'views/find.php',
            'title' => 'Recherche',
            'found' => $found,
            'type' => $type];
    }
}
