<?php
namespace Models;

class Borrowings extends Model {
    public function countCopiesBorrowed( $ISBN ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT COUNT(*) AS nbBorrowings FROM library.borrowings WHERE books_versions_ISBN = :ISBN AND return_date IS NULL'
            );
            $pdoSt->execute( [ ':ISBN' => $ISBN ] );
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function countBooksBorrowed( $code ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT COUNT(*) AS nbBorrowings FROM library.borrowings WHERE users_bar_code = :code AND return_date IS NULL'
            );
            $pdoSt->execute( [ ':code' => $code ] );
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function getBooksBorrowed( $code ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT borrowings.id AS borrowingId, DATE_FORMAT(borrowings.borrowing_date,\'%d/%m/%Y\') AS borrowing_date, DATE_FORMAT(borrowings.deadline_for_return,\'%d/%m/%Y\') AS deadline_for_return, borrowings.books_versions_ISBN AS isbn,
                  books.id AS bookId, books.title AS bookTitle,
                  authors.id AS authorId, authors.alias_name AS authorName
                  FROM library.borrowings
                  JOIN books_versions ON borrowings.books_versions_ISBN = books_versions.ISBN
                  JOIN books ON books_versions.books_id = books.id
                  JOIN authors ON books.authors_id = authors.id
                  WHERE borrowings.users_bar_code = :code AND borrowings.return_date IS NULL
                  ORDER BY borrowings.borrowing_date'
            );
            $pdoSt->execute( [ ':code' => $code ] );
            return $pdoSt->fetchAll();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function addBorrowing( $users_bar_code, $books_versions_ISBN, $borrowing_date = null, $duration = 1 ) {
        try {
            if( !$borrowing_date ) $borrowing_date = date("Y-m-d");
            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.borrowings
                  ( borrowing_date, deadline_for_return, users_bar_code, books_versions_ISBN ) VALUES
                  ( :borrowing_date, DATE_ADD( :starting_date,INTERVAL :duration MONTH ), :users_bar_code, :books_versions_ISBN )'
            );
            $pdoSt->execute([
                ':borrowing_date' => $borrowing_date,
                ':starting_date' => $borrowing_date,
                ':duration' => $duration,
                ':users_bar_code' => $users_bar_code,
                ':books_versions_ISBN' => $books_versions_ISBN
            ]);
            return true;
        } catch ( \PDOException $exception ) {
            return false;
        }
    }
}
