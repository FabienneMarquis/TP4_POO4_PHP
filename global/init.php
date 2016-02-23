<?php

// Inclusion du fichier de configuration (qui définit des constantes)
include_once 'global/config.php';

// Chargement automatique des classes lors de l'utilisation d'un "new"
//
spl_autoload_register(function ($class) {
    if (file_exists(CHEMIN_LIB . $class . '.class.php')) {
        include_once CHEMIN_LIB . $class . '.class.php';
    } else if (file_exists(CHEMIN_MODELE .$class . '.php'))
        include_once CHEMIN_MODELE  .$class. '.php';
});

// Utilisation et démarrage des sessions
session_start();


// Début du fichier identique

// Vérifie si l'utilisateur est connecté
function utilisateur_est_connecte()
{

    return !empty($_SESSION['id']);
}

// Vérifications pour la connexion automatique
// Le mec n'est pas connecté mais les cookies sont là, on y va !
if (!utilisateur_est_connecte() && !empty($_COOKIE['id']) && !empty($_COOKIE['connexion_auto'])) {


    $infos_utilisateur = membres::lire_infos_utilisateur($_COOKIE['id']);

    if (false !== $infos_utilisateur) {
        $navigateur = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $hash = sha1('aaa' . $infos_utilisateur['nom_utilisateur'] . 'bbb' . $infos_utilisateur['mot_de_passe'] . 'ccc' . $navigateur . 'ddd');

        if ($_COOKIE['connexion_auto'] == $hash) {
            // On enregistre les informations dans la session
            $_SESSION['id'] = $_COOKIE['id'];
            $_SESSION['pseudo'] = $infos_utilisateur['nom_utilisateur'];
            $_SESSION['avatar'] = $infos_utilisateur['avatar'];
            $_SESSION['email'] = $infos_utilisateur['adresse_email'];
        }
    }
}