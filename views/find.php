<?php
require 'partials/_header.php';
require 'partials/_search.php';

if ( $data['found'] === null ) {
    echo 'Aucun résultat n\'a été trouvé';
} else { ?>
    <ul>
        <?php
        foreach ($data['found'] as $result){
            echo '<li>' . $result->full_name . '</li>' ;
        } ?>
    </ul><?php
}
