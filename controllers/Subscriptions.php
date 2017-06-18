<?php
namespace Controllers;
use Models\Subscriptions as ModelSubscriptions;
use Models\User as ModelUser;
class Subscriptions extends Controller {
    private $modelSubscriptions = null;
    private $modelUser = null;
    public  function __construct()
    {
        $this->modelSubscriptions = new ModelSubscriptions();
        $this->modelUser = new ModelUser();
    }

    public function add() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }

        if(isset($_GET['user']) AND preg_match( "#^[0-9]{6}$#", $_GET['user'])) {
            $bar_code = 'value="' . $_GET['user'] . '"';
        } else {
            $bar_code = '';
        }
        return ['view' => 'views/addSubscription.php',
            'bar_code' => $bar_code];
    }

    public function added() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        if( !isset($_POST['bar_code']) OR !preg_match( "#^[0-9]{6}$#", $_POST['bar_code'] ) OR
            !isset($_POST['duration']) OR !preg_match( "#^[1-9][0-9]*$#", $_POST['duration'] )) {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). L\'abonnement n\'est pas actif !';
            $_SESSION['error'][] = $_POST;
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
            exit;
        }
        if( !$this->modelUser->getUser( $_POST['bar_code'] ) ) {
            $_SESSION['error'][] = 'Aucun membre n\'est associé à ce code barre';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
            exit;
        }

        if( $ending_date = $this->modelSubscriptions->addSubscription( $_POST['bar_code'], $_POST['duration'] )) {
            $_SESSION['error'][] = 'L\'abonnement du membre a été prolongé de ' . $_POST['duration'] . ' mois';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie';
        }
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
        exit;
    }
}
