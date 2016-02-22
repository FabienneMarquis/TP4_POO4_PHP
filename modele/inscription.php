<?php

function ajouter_membre_dans_bdd($nom_utilisateur, $mdp, $adresse_email, $hash_validation) {

    $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("INSERT INTO membres SET
        nom_utilisateur = :nom_utilisateur,
        mot_de_passe = :mot_de_passe,
        adresse_email = :adresse_email,
        date_inscription = NOW()");

    $requete->bindValue(':nom_utilisateur', $nom_utilisateur);
    $requete->bindValue(':mot_de_passe',    $mdp);
    $requete->bindValue(':adresse_email',   $adresse_email);

    if ($requete->execute()) {

        return $pdo->lastInsertId();
    }
    return $requete->errorInfo();
}
function maj_avatar_membre($id_utilisateur , $avatar) {

    $pdo = PDO2::getInstance();

    $requete = $pdo->prepare("UPDATE membres SET
		avatar = :avatar
		WHERE
		id = :id_utilisateur");

    $requete->bindValue(':id_utilisateur', $id_utilisateur);
    $requete->bindValue(':avatar',         $avatar);

    return $requete->execute();
}