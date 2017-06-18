<ul>
    <?php
    foreach ($data['booksList'] as $book){
        echo '<li><a href="index.php?r=books&a=zoom&id='. $book->id .'">' . $book->title . '</a></li>' ;
    } ?>
</ul>