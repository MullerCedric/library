<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php //<?= $data['title'] ?> - Bibliothèque des Chiroux</title>
<!--    <link rel="stylesheet" href="./views/css/screen.css">-->
</head>
<body>
<?php require $data['view'];
$_SESSION['error'] = [];
unset( $_SESSION['error'] );
$_SESSION['success'] = [];
unset( $_SESSION['success'] ); ?>

<footer>
    <p>Made by Cédric Müller in 2017</p>
</footer>
</body>
</html>