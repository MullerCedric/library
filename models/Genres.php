<?php
namespace Models;

class Genres extends Model {
    public function getGenres( $order = null ) {
        switch ($order) {
            case "za":
                $sql = 'SELECT * FROM library.genres ORDER BY name DESC';
                break;
            case "top":
                $sql = 'SELECT COUNT( borrowings.id ) AS reservations,
                        genres.id, genres.name
                        FROM borrowings
                        JOIN books_versions ON borrowings.books_versions_ISBN = books_versions.ISBN
                        JOIN books ON books_versions.books_id = books.id
                        JOIN genres ON books.genres_id = genres.id
                        GROUP BY genres.id ORDER BY reservations DESC ';
                break;
            default:
                $sql = 'SELECT * FROM library.genres ORDER BY name';
        }
        try {
            $pdoSt = $this->cn->query( $sql );
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
            return true;
        } catch ( \PDOException $exception ) {
            return false;
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
