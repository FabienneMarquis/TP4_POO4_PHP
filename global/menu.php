<?php
if (!isset($_SESSION['user']))
    echo '
<div id="menu">
    <ul>
        <li class="left"><a href="index.php?module=membres&amp;action=inscription">Inscription </a></li>
        <li class="left"><a href="index.php?module=connexion&amp;action=connexion">Connexion</a></li>
        <li> Bienvenu!</li>
    </ul>
</div>
';


else
    echo '

<div id="menu">
    <ul>
        <li class="left"><a href="index.php?module=user&amp;action=profil">Votre profil </a></li>
        <li class="left"><a href="index.php?module=forum&amp;action=forum">Forum</a></li>
        <li class="left"><a href="index.php?module=user&amp;action=disconnect">Deconnexion</a></li>
        <li> Bienvenue ' . $_SESSION['user']->getName() . '!</li>
    </ul>
</div>
'
?>
