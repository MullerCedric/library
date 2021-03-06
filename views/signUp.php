<div class="main-content">
    <h1>S'inscrire</h1>
    <form action="index.php" method="post">
        <fieldset>
            <legend>Vos infos d'identification</legend>
            <p>
                <span>Votre numéro de code barre </span>
                <span><?= $data['newBarCode']; ?></span>
                <input type="hidden" value="<?= $data['newBarCode']; ?>" name="bar_code" >
            </p>
            <p>
                <label for="password">
                    <span>Votre mot de passe*</span>
                </label>
                <input type="password" id="password" name="password" required>
            </p>
        </fieldset>
        <fieldset>
            <legend>Complétez votre profil</legend>
            <p>
                <label for="first_name">
                    <span>Votre prénom*</span>
                </label>
                <input type="text" id="first_name" name="first_name" placeholder="Jane" required>
            </p>
            <p>
                <label for="last_name">
                    <span>Votre nom*</span>
                </label>
                <input type="text" id="last_name" name="last_name" placeholder="Doe" required>
            </p>
            <p>
                <label for="email">
                    <span>Votre e-mail*</span>
                </label>
                <input type="email" id="email" name="email" placeholder="jonh.doe@gmail.com" required>
            </p>
        </fieldset>
        <fieldset>
            <legend>Votre adresse</legend>
            <p>
                <label for="city">
                    <span>Votre ville*</span>
                </label>
                <input type="text" id="city" name="city" placeholder="Liège" required>
            </p>
            <p>
                <label for="postal_code">
                    <span>Votre code postal*</span>
                </label>
                <input type="number" id="postal_code" name="postal_code" placeholder="4000" required>
            </p>
            <p>
                <label for="address">
                    <span>Rue et numéro*</span>
                </label>
                <input type="text" id="address" name="address" placeholder="Rue des Guillemins, 15" required>
            </p>
        </fieldset>

        <input type="hidden" name="r" value="user">
        <input type="hidden" name="a" value="signedUp">
        <p><input type="submit" value="Valider"></p>
    </form>
</div>
