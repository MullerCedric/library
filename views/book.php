<?php
if ( $data['book'] === null OR empty( $data['book'] ) ) : ?>
    <div>
        Aucun résultat n'a été trouvé
    </div>
<?php else : ?>
    <div>
        <p>
            Titre : <?= $data['book']->title ?>
        </p>
        <p>
            Auteur : <a href="index.php?r=authors&a=zoom&id=<?= $data['book']->author_id ?>"><?= $data['book']->author ?></a>
        </p>
        <p>
            Genre : <?= $data['book']->genre ?>
        </p>
        <p>
            Synopsis : <?php
            if( is_null($data['book']->synopsis ) ) echo 'Aucune information';
            else echo $data['book']->synopsis; ?>
        </p>
        <p>
            tags : <?php
            if( is_null($data['book']->tags ) ) echo 'Aucune information';
            else echo $data['book']->tags; ?>
        </p>
    </div>
    <div>
        <ul><?php
            foreach ($data['book_versions'] as $version){
                echo '<li>' . $version->publication;
                if( $version->hasCopiesLeft ) {
                    echo ' <a href="index.php?r=borrowings&a=added&isbn='. urlencode($version->ISBN) .'">Réserver cette version</a>' ;
                } else {
                    echo ' Tous les exemplaires de cette version sont actuellement réservés';
                }
                if( isset($_SESSION['user']) && $_SESSION['user']->is_admin ) {
                    echo ' <a href="index.php?r=books&a=addedCopy&isbn='. urlencode($version->ISBN) .'">Ajouter une copie de cette version</a>';
                }
                echo '</li>';
            }?>
        </ul><?php
        if( isset($_SESSION['user']) && $_SESSION['user']->is_admin ) {
            echo ' <a href="index.php?r=books&a=addVersion&id='. $data['book']->id .'">Ajouter une version à ce livre</a>';
        }?>
    </div>
<?php endif; ?>
