Trier les livres par
<ul>
    <li><a href="index.php?r=books&a=list&order=last">Derniers ajouts</a></li>
    <li><a href="index.php?r=books&a=list&order=az">Ordre alphabétique (A-Z)</a></li>
    <li><a href="index.php?r=books&a=list&order=za">Ordre alphabétique (Z-A)</a></li>
    <li><a href="index.php?r=books&a=list&order=genre">Genre</a></li>
    <li><a href="index.php?r=books&a=list&order=top">Popularité</a></li>
</ul>
<ul>
    <?php
    foreach ($data['booksList'] as $book){
        echo '<li><a href="index.php?r=books&a=zoom&id='. $book->id .'">' . $book->title . '</a></li>' ;
    } ?>
</ul>