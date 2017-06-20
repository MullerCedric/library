<div class="main-content">
    <h1>Éditer le livre <strong><?= $data['book']->title; ?></strong></h1>
    <form action="index.php" method="post">
        <fieldset>
            <legend>Informations générales à propos du livres</legend>
            <p>
                <label for="title">
                    <span>Titre du livre*</span>
                </label>
                <input type="text" id="title" name="title" value="<?= $data['book']->title; ?>">
            </p>
            <p>
                <label for="authors_id">
                    <span>Auteur</span>
                </label>
                <select id="authors_id" name="authors_id">
                    <?php
                    foreach ($data['authorsList'] as $author){
                        if ( $author->id == $data['book']->author_id ) {
                            echo '<option value="' . $author->id . '" selected>' . $author->alias_name . '</option>' ;
                        } else {
                            echo '<option value="' . $author->id . '">' . $author->alias_name . '</option>' ;
                        }
                    } ?>
                </select>
            </p>
            <p>
                <label for="genres_id">
                    <span>Genre</span>
                </label>
                <select id="genres_id" name="genres_id">
                    <?php
                    foreach ($data['genresList'] as $genre){
                        if ( $genre->id == $data['book']->genre_id ) {
                            echo '<option value="' . $genre->id . '" selected>' . $genre->name . '</option>' ;
                        } else {
                            echo '<option value="' . $genre->id . '">' . $genre->name . '</option>' ;
                        }
                    } ?>
                </select>
            </p>
            <p>
                <label for="synopsis">
                    <span>Synopsis</span>
                </label>
                <textarea id="synopsis" name="synopsis"><?= $data['book']->synopsis; ?></textarea>
            </p>
            <p>
                <label for="tags">
                    <span>Tags, séparés par une virgule</span>
                </label>
                <input type="text" id="tags" name="tags" value="<?= $data['book']->tags; ?>">
            </p>
        </fieldset>

        <input type="hidden" name="id" value="<?= $data['book']->id; ?>">
        <input type="hidden" name="r" value="books">
        <input type="hidden" name="a" value="edited">
        <p><input type="submit" value="Valider"></p>
    </form>
</div>
