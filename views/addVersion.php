<div class="main-content">
    <h1>Ajouter une version d'un livre</h1>
    <p>
        Merci de vérifier que la version de votre livre n'est pas déjà encodée. Si vous avez plusieurs fois la même version d'un livre et que la version a déjà été ajoutée ici, vous pouvez ajouter une copie via la page personnalisée du livre en question.
    </p>
    <form action="index.php" method="post">
        <p>
            <label for="books_id">
                <span>Livre auquel ajouter une version : </span>
            </label>
            <select id="books_id" name="books_id">
                <?php
                foreach ($data['booksList'] as $book){
                    echo '<option value="' . $book->id . '">' . $book->title . '</option>' ;
                } ?>
            </select>
        </p>
        <?php require 'partials/_addVersion.php'; ?>

        <input type="hidden" name="r" value="books">
        <input type="hidden" name="a" value="addedVersion">
        <p><input type="submit" value="Valider"></p>
    </form>
</div>
