<?php

// Identifiants pour la base de données. Nécessaires a PDO2.
define ('SQL_DSN', 'mysql:dbname=tp4_poo4_php;host=localhost');
define ('SQL_USERNAME', 'root');
define ('SQL_PASSWORD', '');

 
$module = empty ($module) ? !empty ($_GET ['module']) ? $_GET ['module'] : 'index' : $module;
define ('CHEMIN_VUE', 'modules/' . $module . '/vues/');
define ('CHEMIN_MODELE', 'modele/');
define ('CHEMIN_LIB', 'libs/');
define('CHEMIN_VUE_GLOBALE', 'vues_globales/');

// Configurations relatives à l'avatar
define('AVATAR_LARGEUR_MAXI', 100);
define('AVATAR_HAUTEUR_MAXI', 100);
define('DOSSIER_AVATAR','images/avatar/');