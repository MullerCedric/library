<ul>
    <?php
    foreach ($data['genresList'] as $genre){
        echo '<li>' . $genre->name . '</li>' ;
    } ?>
</ul>