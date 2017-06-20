<form action="index.php" method="get" class="search">
    <label for="type">
        <span>Rechercher...</span>
    </label>
    <select id="type" name="type">
        <option value="book">un livre</option>
        <option value="author">un auteur</option>
        <option value="genre">un genre</option>
    </select>
    <label for="q">
        <span>Terme de votre recherche</span>
    </label>
    <input type="search" id="q" name="q">

    <input type="hidden" name="r" value="search">
    <input type="hidden" name="a" value="find">

    <input type="submit" value="Lancer la recherche">
</form>