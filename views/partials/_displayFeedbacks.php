<?php
if( isset($_SESSION['error']) ) {
    foreach ($_SESSION['error'] as $error) {
        echo '<div class="error">'.$error.'</div>';
    }
}
if( isset($_SESSION['warning']) ) {
    foreach ($_SESSION['warning'] as $warning) {
        echo '<div class="warning">'.$warning.'</div>';
    }
}
if( isset($_SESSION['success']) ) {
    foreach ($_SESSION['success'] as $success) {
        echo '<div class="success">'.$success.'</div>';
    }
}
