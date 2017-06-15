<?php
namespace Models;

class User extends Model {
    public function getUser( $code, $password ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT * FROM library.users WHERE bar_code = :code AND password = :password'
            );
            $pdoSt->execute([
                ':code' => $code,
                ':password' => $password
            ]);
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function isAValidBarCode( $code ) {
        if ( preg_match( "#^[0-9]{6}$#", trim( $code ) ) ) {
            return true;
        }
        return false;
    }

    public function isAValidPassword( $password ) {
        if ( preg_match( "#^(.*[A-Z].*[^a-zA-Z].*|.*[^a-zA-Z].*[A-Z].*)$#", trim( $password ) ) ) {
            return true;
        }
        return false;
    }

    public function isAValidString( $string ) {
        if ( is_string( $string ) && preg_match( "#^.+$#", trim( $string ) ) ) {
            return true;
        }
        return false;
    }

    public function isAValidEmail( $email ) {
        return filter_var( $email, FILTER_VALIDATE_EMAIL );
    }

    public function isAValidPostalCode( $code ) {
        if ( preg_match( "#^[1-9][0-9]{3}$#", trim( $code ) ) ) {
            return true;
        }
        return false;
    }

    public function addUser( $user ) {
        try {
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.users
                  ( bar_code, password, first_name, last_name, email, city, postal_code, address ) VALUES
                  ( :bar_code, :password, :first_name, :last_name, :email, :city, :postal_code, :address )'
            );
            $pdoSt->execute([
                ':bar_code' => $user['bar_code'],
                ':password' => $user['password'],
                ':first_name' => $user['first_name'],
                ':last_name' => $user['last_name'],
                ':email' => $user['email'],
                ':city' => $user['city'],
                ':postal_code' => $user['postal_code'],
                ':address' => $user['address']
            ]);
            $_SESSION['success'][] = 'Inscription réussie !';
        } catch ( \PDOException $exception ) {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Inscription échouée !';
            $_SESSION['error'][] = $exception;
        }
    }
}
