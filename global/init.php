<?php

// Inclusion du fichier de configuration (qui définit des constantes)
include_once 'global/config.php';

// Chargement automatique des classes lors de l'utilisation d'un "new"
//
spl_autoload_register ( function ($class) {
	if (file_exists ( CHEMIN_LIB . $class . '.class.php' )) {
	include_once CHEMIN_LIB . $class . '.class.php';
	} else if (file_exists ( CHEMIN_MODELE . $class . '.class.php' ))
	include_once CHEMIN_MODELE . $class . '.class.php';
} );

// Utilisation et démarrage des sessions
session_start ();


