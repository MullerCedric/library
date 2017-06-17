<?php
namespace Models;

class Books extends Model {
    public function getBooks() {
        try {
            $pdoSt = $this->cn->query(
                'SELECT id, title FROM library.books'
            );
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function addBook( $book ) {
        try {
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.books
                  ( title, synopsis, tags, authors_id, series_id, genres_id ) VALUES
                  ( :title, :synopsis, :tags, :authors_id, :series_id, :genres_id )'
            );
            $pdoSt->execute([
                ':title' => $book['title'],
                ':synopsis' => $book['synopsis'],
                ':tags' => $book['tags'],
                ':authors_id' => $book['authors_id'],
                ':series_id' => $book['series_id'],
                ':genres_id' => $book['genres_id']
            ]);
            return $this->cn->lastInsertId();
        } catch ( \PDOException $exception ) {
            return false;
        }
    }

    public function addVersion( $version ) {
        try {
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.books_versions
                  ( ISBN, publication, cover, lang, copies, description, page_number, books_id ) VALUES
                  ( :ISBN, :publication, :cover, :lang, :copies, :description, :page_number, :books_id )'
            );
            $pdoSt->execute([
                ':ISBN' => $version['ISBN'],
                ':publication' => $version['publication'],
                ':cover' => $version['cover'],
                ':lang' => $version['lang'],
                ':copies' => $version['copies'],
                ':description' => $version['description'],
                ':page_number' => $version['page_number'],
                ':books_id' => $version['books_id']
            ]);
            $_SESSION['success'][] = 'Version ajoutéé !';
        } catch ( \PDOException $exception ) {
            $_SESSION['error'][] = $exception;
            $_SESSION['error'][] = 'La connexion à la BDD n\'a pu être établie. L\'ajout de la version a échoué !';
        }
    }

    public function isAValidString( $string ) {
        if ( is_string( $string ) && preg_match( "#^.+$#", trim( $string ) ) ) {
            return true;
        }
        return false;
    }

    public function isAValidPosInt( $i ) {
        if ( intval( $i, 10 ) >= 1 ) {
            return true;
        }
        return false;
    }

    public function checkId( $id ) {
        if ( intval( $id, 10 ) >= 1 ) {
            return $id;
        }
        return null;
    }
    public function checkCoverURL( $url ) {
        if ( preg_match( '#(\.jpg|\.jpeg|\.png)$#', $url ) ) {
            return $url;
        }
        return null;
    }
}
