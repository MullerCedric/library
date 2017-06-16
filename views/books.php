<ul>
    <?php
    foreach ($data['booksList'] as $book){
        echo '<li>' . $book->title . '</li>' ;
    } ?>
</ul>