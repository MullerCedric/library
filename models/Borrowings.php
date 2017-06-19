<?php
namespace Models;

class Borrowings extends Model {
    public function countCopiesBorrowed( $ISBN ) {
        try {
            $pdoSt = $this->cn->prepare(
                'SELECT COUNT(*) AS nbBorrowings FROM library.borrowings WHERE books_versions_ISBN = :ISBN'
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
            $_SESSION['error'][] = $exception->getMessage();
            return false;
        }
    }
}
