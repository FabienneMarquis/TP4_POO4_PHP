<?php
// Création d'un tableau des erreurs

$erreurs_inscription = array();

// Validation des champs suivant les règles en utilisant les données du tableau $_POST
if(isset($form_inscription)){
    if ($form_inscription->is_valid($_POST)) {

        // On vérifie si les 2 mots de passe correspondent
        if ($form_inscription->get_cleaned_data('mdp') != $form_inscription->get_cleaned_data('mdp_verif')) {

            $erreurs_inscription[] = "Les deux mots de passes entrés sont différents !";
        }

        // Si d'autres erreurs ne sont pas survenues
        if (empty($erreurs_inscription)) {

            // Traitement du formulaire à faire ici
            $user = new User($_POST['nom_utilisateur'], crypt($_POST['mot_de_passe']), $_POST['addresse_email'], date('Y-m-d'), 'none');
            $_SESSION['user'] = $user;
            $sql = "INSERT INTO `membres` (`nom_utilisateur`,`mot_de_passe`,`adresse_email`,`date_inscription`,`avatar`)
          VALUES ('" . $user->getName() . "','" . $user->getPassword()."','".$user->getEmail()."','".$user->getInscriptionDate()."','".$user->getAvatar()."')";
            echo $sql;
            PDO2::getInstance()->exec($sql);

        } else {

            // On affiche à nouveau le formulaire d'inscription
            include CHEMIN_VUE.'formulaire_inscription.php';
        }

    } else {

        // On affiche à nouveau le formulaire d'inscription
        include CHEMIN_VUE.'formulaire_inscription.php';
    }
}else{
    include CHEMIN_VUE.'formulaire_inscription.php';
}

