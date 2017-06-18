<?php
require 'partials/_header.php'; ?>

<div class="main-content">
    <h1>Ajouter ou prolonger l'abonnement d'un membre</h1>
    <form action="index.php" method="post">
        <p>
            <label for="bar_code">
                <span>Code barre du membre*</span>
            </label>
            <input type="number" id="bar_code" name="bar_code" max="999999" <?= $data['bar_code']; ?>>
        </p>
        <p>
            <label for="duration">
                <span>Durée (en mois)*</span>
            </label>
            <input type="number" id="duration" name="duration" max="36" value="12">
        </p>

        <input type="hidden" name="r" value="subscriptions">
        <input type="hidden" name="a" value="added">
        <p><input type="submit" value="Valider"></p>
    </form>
</div>
