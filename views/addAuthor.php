<h1>Ajouter un auteur</h1>
<form action="index.php" method="post">
    <p>
        <label for="name">
            <span>Nom/alias de l'auteur*</span>
        </label>
        <input type="text" id="name" name="name">
    </p>
    <p>
        <label for="birth_date">
            <span>Date de naissance de l'auteur</span>
        </label>
        <input type="date" id="birth_date" name="birth_date">
    </p>
    <p>
        <label for="picture">
            <span>Photo de l'auteur (jpeg/jpg, png)</span>
        </label>
        <input type="url" id="picture" name="picture">
    </p>
    <p>
        <label for="description">
            <span>Description de l'auteur (Sera affichée dans sa page personnalisée)</span>
        </label>
        <textarea id="description" name="description"></textarea>
    </p>

    <input type="hidden" name="r" value="authors">
    <input type="hidden" name="a" value="added">

    <p><input type="submit" value="Ajouter l'auteur"></p>
</form>