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
            'title' => 'Ajouter/prolonger un abonnement',
            'bar_code' => $bar_code];
    }

    public function added() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->is_admin) {
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        if( !isset($_POST['bar_code']) OR !preg_match( "#^[0-9]{6}$#", $_POST['bar_code'] ) ) {
            $_SESSION['error'][] = 'Le code barre fourni est incorrect. Merci de l\'écrire sous le format : <span class="format">000000</span>';
        }
        if( !isset($_POST['duration']) OR !preg_match( "#^[1-9][0-9]*$#", $_POST['duration'] ) ) {
            $_SESSION['error'][] = 'Merci d\'entrer une durée d\'abonnement valide (à partir de 1 mois)';
            $_SESSION['error'][] = $_POST;
        }
        if ( isset( $_SESSION['error'] ) ) {
            $_SESSION['error'][] = 'L\'abonnement n\'a pas été activé !';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
            exit;
        }
        if( !$this->modelUser->getUser( $_POST['bar_code'] ) ) {
            $_SESSION['error'][] = 'Aucun membre n\'est associé à ce code barre';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
            exit;
        }

        if( $this->modelSubscriptions->addSubscription( $_POST['bar_code'], $_POST['duration'] ) ) {
            $_SESSION['success'][] = 'L\'abonnement du membre a été prolongé de ' . $_POST['duration'] . ' mois';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie';
        }
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=subscriptions&a=add' );
        exit;
    }
}
