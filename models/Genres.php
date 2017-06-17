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

    public function findGenre( $term ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT id, name FROM library.genres WHERE name LIKE :term '
            );
            $pdoSt->bindValue(':term', "%$term%");
            $pdoSt->execute();
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }
}
