<?php
if ( $data['author'] === null OR empty( $data['author'] ) ) : ?>
    <div>
        Aucun résultat n'a été trouvé
    </div>
<?php else : ?>
    <div>
        <p>
            Nom : <?= $data['author']->alias_name ?>
        </p>
        <p>
            Date de naissance : <?php
            if( is_null($data['author']->birth_date ) ) echo 'Aucune information';
            else echo $data['author']->birth_date; ?>
        </p>
        <p>
            Description : <?php
            if( is_null($data['author']->description ) ) echo 'Aucune information';
            else echo $data['author']->description; ?>
        </p>
    </div>
    <div>
        <?php if ( empty( $data['books'] ) ) {
            echo '<p>Nous n\'avons actuellement aucun livre de cet auteur</p>';
        } else {
            echo '<ul>';
            foreach ($data['books'] as $book){
                echo '<li><a href="index.php?r=books&a=zoom&id='. $book->id .'">' . $book->title . '</a></li>' ;
            }
            echo '</ul>';
        }?>
    </div>
<?php endif; ?>
