<ul>
    <?php
    foreach ($data['authorsList'] as $author){
        echo '<li>' . $author->alias_name . '</li>' ;
    } ?>
</ul>