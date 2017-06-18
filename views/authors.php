<ul>
    <?php
    foreach ($data['authorsList'] as $author){
        echo '<li><a href="index.php?r=authors&a=zoom&id='. $author->id .'">' . $author->alias_name . '</a></li>' ;
    } ?>
</ul>