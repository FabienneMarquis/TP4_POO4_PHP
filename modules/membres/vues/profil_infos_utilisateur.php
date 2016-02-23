<h2>Profil de <?php echo htmlspecialchars($nom_utilisateur); ?></h2>

<p>
    <img class="flottant_droite" src="<?php echo DOSSIER_AVATAR.urlencode($avatar); ?>" title="Avatar de <?php echo htmlspecialchars($nom_utilisateur); ?>" />
    <span class="label_profil">Adresse email</span> : <?php echo htmlspecialchars($adresse_email); ?><br />
    <span class="label_profil">Date d'inscription</span> : <?php echo $date_inscription; ?>
</p>
