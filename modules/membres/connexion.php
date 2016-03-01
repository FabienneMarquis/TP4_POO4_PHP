<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-23
 * Time: 08:55
 */



// Vérification des droits d'accès de la page
if (utilisateur_est_connecte()) {

    // On affiche la page d'erreur comme quoi l'utilisateur est déjà connecté
    include CHEMIN_VUE_GLOBALE.'erreur_deja_connecte.php';

} else {

// "formulaire_connexion" est l'ID unique du formulaire
    $form_connexion = new Form('formulaire_connexion');

    $form_connexion->method('POST');

    $form_connexion->add('Text', 'nom_utilisateur')
        ->label("Votre nom d'utilisateur");

    $form_connexion->add('Password', 'mot_de_passe')
        ->label("Votre mot de passe");
    // Ajoutons d'abord une case à cocher au formulaire de connexion
    $form_connexion->add('Checkbox', 'connexion_auto')
        ->label("Connexion automatique");


    $form_connexion->add('Submit', 'submit')
        ->value("Connectez-moi !");

// Pré-remplissage avec les valeurs précédemment entrées (s'il y en a)
    $form_connexion->bound($_POST);


// Création d'un tableau des erreurs
    $erreurs_connexion = array();

// Validation des champs suivant les règles
    if ($form_connexion->is_valid($_POST)) {

        list($nom_utilisateur, $mot_de_passe) =
            $form_connexion->get_cleaned_data('nom_utilisateur', 'mot_de_passe');

        // On veut utiliser le modèle des membres (~/modeles/membres.php)

        // combinaison_connexion_valide() est définit dans ~/modeles/membres.php

        $id_utilisateur = membres::combinaison_connexion_valide($nom_utilisateur, sha1($mot_de_passe));

        // Si les identifiants sont valides
        if (false !== $id_utilisateur) {

            $infos_utilisateur = membres::lire_infos_utilisateur($id_utilisateur);

            // On enregistre les informations dans la session
            $_SESSION['id']     = $id_utilisateur;
            $_SESSION['pseudo'] = $nom_utilisateur;
            $_SESSION['avatar'] = $infos_utilisateur['avatar'];
            $_SESSION['email']  = $infos_utilisateur['adresse_email'];
            if (false != $form_connexion->get_cleaned_data('connexion_auto'))
            {
                $navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
                $hash_cookie = sha1('aaa'.$nom_utilisateur.'bbb'.$mot_de_passe.'ccc'.$navigateur.'ddd');

                setcookie( 'id',            $_SESSION['id'], strtotime("+1 year"), '/');
                setcookie('connexion_auto', $hash_cookie,    strtotime("+1 year"), '/');
            }
            // Affichage de la confirmation de la connexion
            include CHEMIN_VUE.'connexion_ok.php';

        } else {

            $erreurs_connexion[] = "Couple nom d'utilisateur / mot de passe inexistant.";

            // Suppression des cookies de connexion automatique
            setcookie('id', '');
            setcookie('connexion_auto', '');
            // On réaffiche le formulaire de connexion
            include CHEMIN_VUE.'formulaire_connexion.php';
        }

    } else {

        // On réaffiche le formulaire de connexion
        include CHEMIN_VUE.'formulaire_connexion.php';
    }

    // Reste de la page comme avant
}


