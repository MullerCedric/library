<?php
namespace Controllers;

class Controller {
    protected function is_connected() {
        if ( isset( $_SESSION['user'] ) AND isset( $_SESSION['user']->bar_code ) AND isset( $_SESSION['user']->password ) ) {
            return true;
        } else {
            return false;
        }
    }
}
