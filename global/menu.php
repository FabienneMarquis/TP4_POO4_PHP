
<?php if (!utilisateur_est_connecte()) { ?>

<div id="menu">
    <ul>
        <li class="left"><a href="index.php?module=membres&amp;action=inscription">Inscription </a></li>
        <li class="left"><a href="index.php?module=membres&amp;action=connexion">Connexion</a></li>
        <li> Bienvenu!</li>
    </ul>
</div>



<?php } else { ?>
    <div id="menu">
        <ul>
            <li class="left"><a href="index.php?module=membres&amp;action=afficher_profil&amp;id=<?php echo $_SESSION['id']; ?>">Votre profil </a></li>
            <li class="left"><a href="index.php?module=forum&amp;action=afficher_forum">Forum</a></li>
            <li class="left"><a href="index.php?module=membres&amp;action=deconnexion">Deconnexion</a></li>
            <li class="left"><a href="index.php?module=membres&amp;action=modifier_profil">Modifier Profil</a></li>
            <li> Bienvenue <?php echo $_SESSION['pseudo']; ?>!</li>
        </ul>
    </div>
<?php } ?>



