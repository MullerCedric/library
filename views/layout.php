<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $data['title']; ?> - Bibliothèque des Chiroux</title>
    <link rel="stylesheet" href="./assets/css/screen.css">
</head>
<body>
<?php require 'partials/_header.php'; ?>
<main>
    <?php require $data['view']; ?>
</main>

<footer>
    <?php require 'partials/_footer.php'; ?>
</footer>
</body>
</html>