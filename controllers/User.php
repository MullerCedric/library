<?php
namespace Controllers;

use Models\Model as Model;
use Models\User as ModelUser;

class User extends Controller
{
    private $model = null;
    private $modelUser = null;

    public function __construct()
    {
        $this->model = new Model();
        $this->modelUser = new ModelUser();
    }

    public function signUp()
    {
        if ($this->is_connected()) {
            $_SESSION['error'][] = 'Vous êtes déjà inscrit !';
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        $newBarCode = random_int(100000, 999999);
        while ($this->modelUser->getUser($newBarCode)) {
            $newBarCode = random_int(100000, 999999);
        }
        return ['view' => 'views/signUp.php',
            'title' => 'S\'inscrire',
            'newBarCode' => $newBarCode];
    }

    public function signedUp()
    {
        if ($this->is_connected()) {
            $_SESSION['error'][] = 'Vous êtes déjà inscrit !';
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        if (!isset($_POST['bar_code']) || !preg_match("#^[0-9]{6}$#", trim($_POST['bar_code'])) || $this->modelUser->getUser($_POST['bar_code'])) {
            $_SESSION['error'][] = 'Le code barre fourni est incorrect. Veuillez réessayer';
        }
        if (!isset($_POST['password']) || !preg_match("#^(.*[A-Z].*[^a-zA-Z].*|.*[^a-zA-Z].*[A-Z].*)$#", trim($_POST['password']))) {
            $_SESSION['error'][] = 'Le mot de passe fourni est incorrect. Ce dernier doit contenir au moins une majuscule et un caractère qui n\'est pas une lettre ';
        }
        if (!isset($_POST['first_name']) || strlen(trim($_POST['first_name'])) < 2) {
            $_SESSION['error'][] = 'Le prénom fourni est incorrect. Merci de l\'écrire sous le format : <span class="format">Prénom</span>';
        }
        if (!isset($_POST['last_name']) || strlen(trim($_POST['last_name'])) < 2) {
            $_SESSION['error'][] = 'Le nom fourni est incorrect. Merci de l\'écrire sous le format : <span class="format">Nom</span>';
        }
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'L\'adresse e-mail fournie est incorrecte. Merci de l\'écrire sous le format : <span class="format">adresse@domaine.ext</span>';
        }
        if (!isset($_POST['city']) || strlen(trim($_POST['city'])) < 2) {
            $_SESSION['error'][] = 'La ville fournie est incorrecte. Merci de l\'écrire sous le format : <span class="format">Ville</span>';
        }
        if (!isset($_POST['postal_code']) || !preg_match("#^[1-9][0-9]{3}$#", trim($_POST['postal_code']))) {
            $_SESSION['error'][] = 'Le code postal fourni est incorrect. Merci de l\'écrire sous le format : <span class="format">0000</span>';
        }
        if (!isset($_POST['address']) || !preg_match("#^[a-zA-Z]{3,}[ a-zA-Z]*,? ?[0-9]+$#", trim($_POST['address']))) {
            $_SESSION['error'][] = 'L\'adresse fournie est incorrecte. Merci de l\'écrire sous le format : <span class="format">rue, numéro</span>';
        }
        if (isset($_SESSION['error'])) {
            $_SESSION['error'][] = 'Inscription échouée !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=user&a=signUp');
            exit;
        }

        if ($this->modelUser->addUser([
            'bar_code' => $_POST['bar_code'],
            'password' => hash('sha256', $_POST['password']),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'city' => $_POST['city'],
            'postal_code' => $_POST['postal_code'],
            'address' => $_POST['address']
        ])
        ) {
            $_SESSION['success'][] = 'Inscription réussie !';
        } else {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Inscription échouée !';
        }
        header('Location: ' . HARDCODED_URL . 'index.php?r=user&a=logIn');
        exit;
    }

    public function logIn()
    {
        if ($this->is_connected()) {
            $_SESSION['error'][] = 'Vous êtes déjà connecté !';
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        return ['view' => 'views/logIn.php',
            'title' => 'Se connecter'];
    }

    public function loggedIn()
    {
        if ($this->is_connected()) {
            $_SESSION['error'][] = 'Vous êtes déjà connecté !';
            header('Location: ' . HARDCODED_URL);
            exit;
        }
        if (!isset($_POST['code']) || !preg_match("#^[0-9]{6}$#", trim($_POST['code']))) {
            $_SESSION['error'][] = 'Le code barre fourni est incorrect. Merci de l\'écrire sous le format : <span class="format">000000</span>';
        }
        if (!isset($_POST['password']) || !preg_match("#^(.*[A-Z].*[^a-zA-Z].*|.*[^a-zA-Z].*[A-Z].*)$#", trim($_POST['password']))) {
            $_SESSION['error'][] = 'Le mot de passe fourni est incorrect. Ce dernier doit contenir au moins une majuscule et un caractère qui n\'est pas une lettre ';
        }
        if (isset($_SESSION['error'])) {
            $_SESSION['error'][] = 'Connexion échouée !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=user&a=logIn');
            exit;
        }
        if (!$user = $this->modelUser->getUser($_POST['code'], hash('sha256', $_POST['password']))) {
            $_SESSION['error'][] = 'Votre code barre ou votre mot de passe est incorrect. Connexion échouée !';
            header('Location: ' . HARDCODED_URL . 'index.php?r=user&a=logIn');
            exit;
        }
        $_SESSION['user'] = $user;
        $_SESSION['success'][] = 'Connexion réussie !';
        header('Location: ' . HARDCODED_URL . 'index.php?r=page&a=dashboard');
        exit;
    }

    public function loggedOut()
    {
        $_SESSION = array();
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', 1,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header('Location: ' . HARDCODED_URL);
        exit;
    }

    public function block()
    {

    }

    public function profile()
    {

    }
}
