<h1>Ajouter un genre</h1>
<form action="index.php" method="post">
    <p>
        <label for="name">
            <span>Nom du nouveau genre</span>
        </label>
        <input type="text" id="name" name="name">
    </p>

    <input type="hidden" name="r" value="genres">
    <input type="hidden" name="a" value="added">

    <p><input type="submit" value="Ajouter le genre"></p>
</form>