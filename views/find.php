<?php
if ( $data['found'] === null ) {
    echo 'Aucun résultat n\'a été trouvé';
} else { ?>
    <ul><?php
        switch ( $data['type'] ) {
            case "author":
                foreach ($data['found'] as $author){
                    echo '<li><a href="index.php?r=authors&a=zoom&id='. $author->id .'">' . $author->alias_name . '</a></li>' ;
                }
                break;
            case "book":
                foreach ($data['found'] as $book){
                    echo '<li><a href="index.php?r=books&a=zoom&id='. $book->id .'">' . $book->title . '</a></li>' ;
                }
                break;
            case "genre":
                foreach ($data['found'] as $genre){
                    echo '<li><a href="index.php?r=books&a=list&filter=genre&id='. $genre->id .'">' . $genre->name . '</a></li>' ;
                }
        } ?>
    </ul><?php
}
