<?php
namespace Controllers;
use Models\Authors as ModelAuthors;
use Models\Books as ModelBooks;
use Models\Genres as ModelGenres;
class Search extends Controller {
    private $modelAuthors = null;
    private $modelBooks = null;
    private $modelGenres = null;
    public  function __construct()
    {
        $this->modelAuthors = new ModelAuthors();
        $this->modelBooks = new ModelBooks();
        $this->modelGenres = new ModelGenres();
    }

    public  function find()
    {
        if( !isset( $_GET['type'] ) OR !isset( $_GET['q'] ) OR
            strlen( $_GET['type'] ) < 1 OR strlen( $_GET['q'] ) < 1 ) {
            $_SESSION['error'][] = 'Les paramètres de la recherche sont erronés';
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        switch ( $_GET['type'] ) {
            case "author":
                echo 'Author';
                $found = $this->modelAuthors->findAuthor( $_GET['q'] );
                foreach ($found as $result){
                    $result->full_name = $result->alias_name ;
                }
                break;
            case "book":
                echo 'Book';
                $found = $this->modelBooks->findBook( $_GET['q'] );
                foreach ($found as $result){
                    $result->full_name = $result->title ;
                }
                break;
            case "genre":
                echo 'Genre';
                $found = $this->modelGenres->findGenre( $_GET['q'] );
                foreach ($found as $result){
                    $result->full_name = $result->name ;
                }
                break;
            default:
                $found = null;
        }

        return [ 'view' => 'views/find.php',
            'found' => $found];
    }
}
