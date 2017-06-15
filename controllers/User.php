<?php
namespace Controllers;
use Models\Model as Model;
use Models\User as ModelUser;
class User extends Controller {
    private $model = null;
    private $modelUser = null;
    public  function __construct()
    {
        $this->model = new Model();
        $this->modelUser = new ModelUser();
    }

    public function signUp() {
        return ['view' => 'views/signUp.php'];
    }

    public function signedUp() {
        if(
        !$this->modelUser->isAValidBarCode( $_POST['bar_code'] ) OR
        !$this->modelUser->isAValidPassword( $_POST['password'] ) OR
        !$this->modelUser->isAValidString( $_POST['first_name'] ) OR
        !$this->modelUser->isAValidString( $_POST['last_name'] ) OR
        !$this->modelUser->isAValidEmail( $_POST['email'] ) OR
        !$this->modelUser->isAValidString( $_POST['city'] ) OR
        !$this->modelUser->isAValidPostalCode( $_POST['postal_code'] ) OR
        !$this->modelUser->isAValidString( $_POST['address'] ) ) {
            $_SESSION['error'][] = 'L\'un ou plusieurs des paramètres fourni(s) est/sont incorrect(s). Inscription échouée !';
            header( 'Location: ' . HARDCODED_URL . 'index.php?r=user&a=signIn' );
            exit;
        }

        $this->modelUser->addUser( [
            'bar_code' => $_POST['bar_code'],
            'password' => hash( 'sha256', $_POST['password'] ),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'city' => $_POST['city'],
            'postal_code' => $_POST['postal_code'],
            'address' => $_POST['address']
        ] );

        header( 'Location: ' . HARDCODED_URL . 'index.php?r=user&a=logIn' );
        exit;
    }

    public function logIn() {
        return ['view' => 'views/logIn.php'];
    }

    public function loggedIn() {
        $_SESSION['user'] = null;
        $code = $_POST['code'];
        $password = hash( 'sha256', $_POST['password'] );
        $user = $this->modelUser->getUser( $code, $password );
        if ( !$user ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        $_SESSION['user'] = $user;
        header( 'Location: ' . HARDCODED_URL . 'index.php?r=page&a=dashboard' );
        exit;
    }

    public function loggedOut() {
        $_SESSION = array();
        if ( ini_get('session.use_cookies') ) {
            $params = session_get_cookie_params();
            setcookie( session_name(), '', 1,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header( 'Location: ' . HARDCODED_URL );
        exit;
    }

    public function block() {

    }

    public function profile() {

    }
}
