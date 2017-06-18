<?php
namespace Models;

class Subscriptions extends Model {


    public function getLastSubscription( $code ) {
        try {
            $pdoSt = $this->cn->prepare( 'SELECT * FROM library.subscriptions WHERE user_bar_code = :code ORDER BY ending_date DESC LIMIT 1' );
            $pdoSt->execute([ ':code' => $code ]);
            return $pdoSt->fetch();
        } catch ( \PDOException $exception ) {
            return null;
        }
    }

    public function addSubscription( $code, $duration ) {
        try {
            if ( $lastSub = $this->getLastSubscription( $code ) ) {
                $pdoSt = $this->cn->prepare(
                    'INSERT INTO library.subscriptions
                  ( starting_date, ending_date, user_bar_code ) VALUES
                  ( :starting_date, DATE_ADD(:starting_date,INTERVAL :duration MONTH), :user_bar_code )'
                );
                $pdoSt->execute([
                    ':starting_date' => $lastSub->ending_date,
                    ':duration' => $duration,
                    ':user_bar_code' => $code
                ]);

                return true;
            }

            $pdoSt = $this->cn->prepare(
                'INSERT INTO library.subscriptions
                  ( starting_date, ending_date, user_bar_code ) VALUES
                  ( CURDATE(), DATE_ADD(CURDATE(),INTERVAL :duration MONTH), :user_bar_code )'
            );
            $pdoSt->execute([
                ':duration' => $duration,
                ':user_bar_code' => $code
            ]);
            return true;
        } catch ( \PDOException $exception ) {
            return false;
        }
    }
}
