<?php
namespace Models;

class Model {

    protected $cn = null;

    function __construct()
    {
        if ( !file_exists( DB_FILE ) ) {
            return ['error' => 'Le fichier de configuration de la BDD est introuvable'];
        }

        $dbDatas = parse_ini_file( DB_FILE );
        $dbOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
        try {
            $dsn = sprintf( '%s:dbname=%s;host=%s', $dbDatas['type'], $dbDatas['dbname'], $dbDatas['host'] );
            $this->cn = new \PDO( $dsn, $dbDatas['user'], $dbDatas['password'], $dbOptions );
            $this->cn->exec('SET CHARACTER SET UTF8');
            $this->cn->exec('SET NAMES UTF8');
            return true;
        } catch ( \PDOException $exception ) {
            return ['error' => 'La connexion à la BDD a échoué'];
        }
    }
}
