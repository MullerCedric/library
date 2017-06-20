<?php
namespace Models;

class User extends Model {
    public function getUser( $code, $password = null ) {
        if( is_null( $password ) ) {
            $sql = 'SELECT * FROM library.users WHERE bar_code = :code';
            $param = [ ':code' => $code ];
        } else {
            $sql = 'SELECT * FROM library.users WHERE bar_code = :code AND password = :password';
            $param = [':code' => $code,
                ':password' => $password];
        }
        try {
            $pdoSt = $this->cn->prepare( $sql );
            $pdoSt->execute($param);
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
            return true;
        } catch ( \PDOException $exception ) {
            return false;
        }
    }
}
