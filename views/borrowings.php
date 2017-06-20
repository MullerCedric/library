<?php
if ( $data['borrowings'] === null OR empty( $data['borrowings'] ) ) : ?>
    <div>
        Aucun résultat n'a été trouvé
    </div>
<?php else : ?>
    <table>
        <caption>Liste de vos emprunts</caption>

        <tr>
            <th scope="col">Date d'emprunt</th>
            <th scope="col">À rendre avant</th>
            <th scope="col">Titre du livre emprunté</th>
            <th scope="col">ISBN du livre</th>
            <th scope="col">Auteur</th>
        </tr><?php
        foreach ( $data['borrowings'] as $borrowing ) : ?>
            <tr>
                <td><?= $borrowing->borrowing_date; ?></td>
                <td><?= $borrowing->deadline_for_return; ?></td>
                <td><a href="index.php?r=books&a=zoom&id=<?= $borrowing->bookId; ?>"><?= $borrowing->bookTitle; ?></a></td>
                <td><?= $borrowing->isbn; ?></td>
                <td><a href="index.php?r=authors&a=zoom&id=<?= $borrowing->authorId; ?>"><?= $borrowing->authorName; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
