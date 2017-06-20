Trier les genres par
<ul>
    <li><a href="index.php?r=genres&a=list&order=az">Ordre alphabétique (A-Z)</a></li>
    <li><a href="index.php?r=genres&a=list&order=za">Ordre alphabétique (Z-A)</a></li>
    <li><a href="index.php?r=genres&a=list&order=top">Popularité</a></li>
</ul>
<ul>
    <?php
    foreach ($data['genresList'] as $genre){
        echo '<li><a href="index.php?r=books&a=list&filter='. $genre->id .'">' . $genre->name . '</a></li>' ;
    } ?>
</ul>