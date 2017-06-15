<?php
namespace Models;

class Genres extends Model {
    public function getGenres() {
        try {
            $pdoSt = $this->cn->query(
                'SELECT * FROM library.genres'
            );
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function addGenre( $name ) {
        try {
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.genres ( name ) VALUES ( :name )'
            );
            $pdoSt->execute([
                ':name' => $name
            ]);
            $_SESSION['success'][] = 'Le nouveau genre a bien été ajouté !';
        } catch ( \PDOException $exception ) {
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. Le nouveau genre n\'a pas été ajouté';
        }
    }
}
