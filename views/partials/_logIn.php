<div class="main-content">
    <h1>Qui êtes-vous ?</h1>
    <form action="index.php" method="post">
        <fieldset>
            <legend>Vos infos</legend>
            <p>
                <label for="code">
                    <span>Le numéro de votre code barre <span>(visible sur votre carte Chiroux ou dans le mail d'inscription</span></span>
                </label>
                <input type="number" id="code" name="code">
            </p>
            <p>
                <label for="password">
                    <span>Votre mot de passe</span>
                </label>
                <input type="password" id="password" name="password">
            </p>

            <input type="hidden" name="r" value="user">
            <input type="hidden" name="a" value="loggedIn">

            <p><input type="submit" value="Se connecter"></p>
        </fieldset>
    </form>
</div>
