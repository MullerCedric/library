<ul>
    <?php
    foreach ($data['genresList'] as $genre){
        echo '<li><a href="index.php?r=books&a=list&filter=genre&id='. $genre->id .'">' . $genre->name . '</a></li>' ;
    } ?>
</ul>