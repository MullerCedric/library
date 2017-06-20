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

    public function getBooksFromAuthor( $author_id ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT id, title FROM library.books WHERE authors_id = :author_id'
            );
            $pdoSt->execute( [ ':author_id' => $author_id ] );
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function getBook( $id ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT books.id, books.title, books.synopsis, books.tags,
                  authors.id AS author_id, authors.alias_name AS author,
                  genres.id AS genre_id, genres.name AS genre
                  FROM books
                  JOIN authors ON books.authors_id = authors.id
                  JOIN genres ON books.genres_id = genres.id
                  WHERE books.id = :id;'
            );
            $pdoSt->execute( [ ':id' => $id ] );
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function getBookIdFromISBN( $ISBN ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT books.id AS bookId
                  FROM books
                  JOIN books_versions ON books_versions.books_id = books.id
                  WHERE books_versions.ISBN = :ISBN'
            );
            $pdoSt->execute( [ ':ISBN' => $ISBN ] );
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function getBookVersions( $book_id ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT * FROM library.books_versions WHERE books_id = :book_id'
            );
            $pdoSt->execute( [ ':book_id' => $book_id ] );
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function getVersion( $ISBN ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT * FROM library.books_versions WHERE ISBN = :ISBN'
            );
            $pdoSt->execute( [ ':ISBN' => $ISBN ] );
            return $pdoSt->fetch();
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
            return true;
        } catch ( \PDOException $exception ) {
            return false;
        }
    }

    public function addCopy( $ISBN ) {
        try {
            $pdoSt = $this->cn->prepare(
                'UPDATE books_versions SET copies = copies + 1 WHERE ISBN = :ISBN'
            );
            $pdoSt->execute( [ ':ISBN' => $ISBN ] );
            return true;
        } catch ( \PDOException $exception ) {
            return false;
        }
    }

    public function editBook( $book ) {
        try {
            $pdoSt = $this->cn->prepare(
                'UPDATE books SET title = :title, synopsis = :synopsis, tags = :tags, authors_id = :authors_id, series_id = :series_id, genres_id = :genres_id WHERE id = :id'
            );
            $pdoSt->execute([
                ':title' => $book['title'],
                ':synopsis' => $book['synopsis'],
                ':tags' => $book['tags'],
                ':authors_id' => $book['authors_id'],
                ':series_id' => $book['series_id'],
                ':genres_id' => $book['genres_id'],
                ':id' => $book['id']
            ]);
            return true;
        } catch ( \PDOException $exception ) {
            return false;
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

    public function findBook( $term ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT id, title FROM library.books WHERE books.title LIKE :term OR books.tags LIKE :term '
            );
            $pdoSt->bindValue(':term', "%$term%");
            $pdoSt->execute();
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }
}
