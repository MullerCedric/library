<form action="index.php" method="get">
    <p>
        <label for="type">
            <span>Rechercher...</span>
        </label>
        <select id="type" name="type">
            <option value="book">un livre</option>
            <option value="author">un auteur</option>
            <option value="genre">un genre</option>
        </select>
    </p>
    <p>
        <label for="q">
            <span>Terme de votre recherche</span>
        </label>
        <input type="search" id="q" name="q">
    </p>

    <input type="hidden" name="r" value="search">
    <input type="hidden" name="a" value="find">

    <p><input type="submit" value="Lancer la recherche"></p>
</form>