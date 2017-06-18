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
<?php endif; ?>
