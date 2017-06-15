<?php
namespace Models;

class Page extends Model {
    public function get_view( $page = 'homePage.php', $errors = null ) {
        if ( isset( $page ) && isset( $errors ) ) {
            return [
                'view' => 'views/' . $page . '.php',
                'errors' => $errors,
            ];
        } else {
            return [ 'view' => 'views/' . $page . '.php' ];
        }
    }
}
