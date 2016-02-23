<?php

// Vérification des droits d'accès de la page
if (!utilisateur_est_connecte()) {

    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';

} else {

    // Ne pas oublier d'inclure la librairie Form
    //include CHEMIN_LIB.'form.php';

    // "form_modif_infos" est l'ID unique du formulaire
    $form_modif_infos = new Form("form_modif_infos");
    $form_modif_infos->method('POST');

    $form_modif_infos->add('Email', 'adresse_email')
        ->label("Votre adresse email")
        ->Required(false)
        ->value($_SESSION['email']);

    $form_modif_infos->add('Checkbox', 'suppr_avatar')
        ->label("Je veux supprimer mon avatar")
        ->Required(false);

    $form_modif_infos->add('File', 'avatar')
        ->filter_extensions('jpg', 'png', 'gif')
        ->max_size(8192)// 8 Kb
        ->label("Votre avatar (facultatif)")
        ->Required(false);

    $form_modif_infos->add('Submit', 'submit')
        ->value("Modifier ces informations !");

    // "form_modif_mdp" est l'ID unique du formulaire
    $form_modif_mdp = new Form("form_modif_mdp");
    $form_modif_mdp->method('POST');

    $form_modif_mdp->add('Password', 'mdp_ancien')
        ->label("Votre ancien mot de passe");

    $form_modif_mdp->add('Password', 'mdp')
        ->label("Votre nouveau mot de passe");

    $form_modif_mdp->add('Password', 'mdp_verif')
        ->label("Votre nouveau mot de passe (vérification)");

    $form_modif_mdp->add('Submit', 'submit')
        ->value("Modifier mon mot de passe !");

    // Création des tableaux des erreurs (un par formulaire)
    $erreurs_form_modif_infos = array();
    $erreurs_form_modif_mdp = array();

    // et d'un tableau des messages de confirmation
    $msg_confirm = array();

    // Validation des champs suivant les règles en utilisant les données du tableau $_POST
    if ($form_modif_infos->is_valid($_POST)) {

        list($adresse_email, $suppr_avatar, $avatar) = $form_modif_infos->get_cleaned_data('adresse_email', 'suppr_avatar', 'avatar');

        // On veut utiliser le modèle de l'inscription(~/modules/membres.php)
        //include CHEMIN_MODELE.'membres.php';

        // Si l'utilisateur veut modifier son adresse e-mail
        if (!empty($adresse_email)) {

            $test = membres::maj_adresse_email_membre($_SESSION['id'], $adresse_email);

            if (true === $test) {

                // Ça a marché, trop cool !
                $msg_confirm[] = "Adresse e-mail mise à jour avec succès !";
                $_SESSION['email'] = $adresse_email;
                // Gestion des doublons
            } else {

                // Changement de nom de variable (plus lisible)
                $erreur =& $test;

                // On vérifie que l'erreur concerne bien un doublon
                if (23000 == $erreur[0]) { // Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL

                    preg_match("`Duplicate entry '(.+)' for key %d+`is", $erreur[2], $valeur_probleme);
                    $valeur_probleme = $valeur_probleme[1];

                    if ($adresse_email == $valeur_probleme) {

                        $erreurs_form_modif_infos[] = "Cette adresse e-mail est déjà utilisée.";

                    } else {

                        $erreurs_form_modif_infos[] = "Erreur ajout SQL : doublon non identifié présent dans la base de données.";
                    }

                } else {

                    $erreurs_form_modif_infos[] = sprintf("Erreur ajout SQL : cas non traité (SQLSTATE = %d).", $erreur[0]);
                }

            }
        }

        // Si l'utilisateur veut supprimer son avatar...
        if (!empty($suppr_avatar)) {

            membres::maj_avatar_membre($_SESSION['id'], '');
            $_SESSION['avatar'] = '';

            $msg_confirm[] = "Avatar supprimé avec succès !";

            // ... ou le modifier !
        } else if (!empty($avatar)) {

            // On souhaite utiliser la librairie Image
            include CHEMIN_LIB . 'image.php';

            // Redimensionnement et sauvegarde de l'avatar
            $avatar = new Image($avatar);
            $avatar->resize_to(AVATAR_LARGEUR_MAXI, AVATAR_HAUTEUR_MAXI); // Image->resize_to($largeur_maxi, $hauteur_maxi)
            $avatar_filename = DOSSIER_AVATAR . $id_utilisateur . '.' . strtlower(pathinfo($avatar->get_filename(), PATHINFO_EXTENSION));
            $avatar->save_as($avatar_filename);

            // On veut utiliser le modèle des membres (~/modules/membres.php)
            //include CHEMIN_MODELE.'membres.php';

            // Mise à jour de l'avatar dans la table
            // maj_avatar_membre() est définit dans ~/modules/membres.php
            membres::maj_avatar_membre($_SESSION['id'], $avatar_filename);
            $_SESSION['avatar'] = $avatar_filename;

            $msg_confirm[] = "Avatar modifié avec succès !";
        }

    } else if ($form_modif_mdp->is_valid($_POST)) {

        // On vérifie si les 2 mots de passe correspondent
        if ($form_modif_mdp->get_cleaned_data('mdp') != $form_modif_mdp->get_cleaned_data('mdp_verif')) {

            $erreurs_form_modif_mdp[] = "Les deux mots de passes entrés sont différents !";

            // C'est bon, on peut modifier la valeur dans la BDD
        } else {

            $mdp = $form_modif_mdp->get_cleaned_data('mdp');
            $mdp_ancien = $form_modif_mdp->get_cleaned_data('mdp_ancien');
            if (false != membres::combinaison_connexion_valide($_SESSION['pseudo'], sha1($mdp_ancien))) {
                membres::maj_mot_de_passe_membre($_SESSION['id'], sha1($mdp));
                $msg_confirm[] = "Votre mot de passe a été modifié avec succès !";
            }else {
                $erreurs_form_modif_mdp[] = "L'ancien mot de passe est invalide";
            }
            // On veut utiliser le modèle de l'inscription (~/modules/membres.php)
            //include CHEMIN_MODELE.'membres.php';

        }

    }
}
// Affichage des formulaires de modification du profil
include CHEMIN_VUE . 'formulaires_modifier_profil.php';
