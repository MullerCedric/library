<fieldset>
    <legend>Ajouter une nouvelle version du livre</legend>
    <p>
        <label for="isbn">
            <span>ISBN du livre*</span>
        </label>
        <input type="text" id="isbn" name="isbn" placeholder="ISBN-13: 978-0-552-55211-0">
    </p>
    <p>
        <label for="publication">
            <span>Publication*</span>
        </label>
        <input type="text" id="publication" name="publication" placeholder="London : Corgi books, 2011">
    </p>
    <p>
        <label for="cover">
            <span>Couverture du livre (jpeg/jpg, png)</span>
        </label>
        <input type="url" id="cover" name="cover">
    </p>
    <p>
        <label for="lang">
            <span>Langue*</span>
        </label>
        <input type="text" id="lang" name="lang" placeholder="Français">
    </p>
    <p>
        <label for="copies">
            <span>Nombre de copies*</span>
        </label>
        <input type="number" id="copies" name="copies" value="1" min="1">
    </p>
    <p>
        <label for="description">
            <span>Description</span>
        </label>
        <input type="text" id="description" name="description" placeholder="carte, couv. ill. en coul. ; 20 cm">
    </p>
    <p>
        <label for="page_number">
            <span>Nombre de pages dans cette version*</span>
        </label>
        <input type="number" id="page_number" name="page_number" min="1">
    </p>
</fieldset>