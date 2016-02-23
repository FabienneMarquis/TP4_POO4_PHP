<h2>Modification de votre profil utilisateur</h2>

<?php

if (!empty($msg_confirm)) {

    echo '<ul>'."\n";

    foreach($msg_confirm as $m) {

        echo '	<li>'.$m.'</li>'."\n";
    }

    echo '</ul>';
}

if (!empty($erreurs_form_modif_infos)) {

    echo '<ul>'."\n";

    foreach($erreurs_form_modif_infos as $e) {

        echo '	<li>'.$e.'</li>'."\n";
    }

    echo '</ul>';
}

//$form_modif_infos->fieldsets(array('adresse_email', 'suppr_avatar', 'avatar'));

echo $form_modif_infos;

if (!empty($erreurs_form_modif_mdp)) {

    echo '<ul>'."\n";

    foreach($erreurs_form_modif_mdp as $e) {

        echo '	<li>'.$e.'</li>'."\n";
    }

    echo '</ul>';
}

//$form_modif_mdp->fieldsets(array('mdp_ancien', 'mdp', 'mdp_verif'));

echo $form_modif_mdp;
