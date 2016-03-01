<?php

/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-23
 * Time: 09:02
 */
class membres
{
    public static function ajouter_membre_dans_bdd($nom_utilisateur, $mdp, $adresse_email, $hash_validation)
    {

        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("INSERT INTO membres SET
        nom_utilisateur = :nom_utilisateur,
        mot_de_passe = :mot_de_passe,
        adresse_email = :adresse_email,
        date_inscription = NOW()");

        $requete->bindValue(':nom_utilisateur', $nom_utilisateur);
        $requete->bindValue(':mot_de_passe', $mdp);
        $requete->bindValue(':adresse_email', $adresse_email);

        if ($requete->execute()) {

            return $pdo->lastInsertId();
        }
        return $requete->errorInfo();
    }

    public static function maj_avatar_membre($id_utilisateur, $avatar)
    {

        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("UPDATE membres SET
		avatar = :avatar
		WHERE
		id = :id_utilisateur");

        $requete->bindValue(':id_utilisateur', $id_utilisateur);
        $requete->bindValue(':avatar', $avatar);

        return $requete->execute();
    }

    public static function combinaison_connexion_valide($nom_utilisateur, $mot_de_passe)
    {

        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("SELECT id FROM membres
		WHERE
		nom_utilisateur = :nom_utilisateur AND
		mot_de_passe = :mot_de_passe");

        $requete->bindValue(':nom_utilisateur', $nom_utilisateur);
        $requete->bindValue(':mot_de_passe', $mot_de_passe);
        $requete->execute();

        if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {

            $requete->closeCursor();
            return $result['id'];
        }
        return false;
    }

    public static function lire_infos_utilisateur($id_utilisateur)
    {

        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("SELECT nom_utilisateur, mot_de_passe, adresse_email, avatar, date_inscription, hash_validation
		FROM membres
		WHERE
		id = :id_utilisateur");

        $requete->bindValue(':id_utilisateur', $id_utilisateur);
        $requete->execute();

        if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {

            $requete->closeCursor();
            return $result;
        }
        return false;
    }

    public static function maj_adresse_email_membre($id_utilisateur, $adresse_email)
    {
        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("UPDATE membres SET
		adresse_email = :adresse_email
		WHERE
		id = :id_utilisateur");

        $requete->bindValue(':id_utilisateur', $id_utilisateur);
        $requete->bindValue(':adresse_email', $adresse_email);

        return $requete->execute();
    }

    public static function maj_mot_de_passe_membre($id_utilisateur, $mdp)
    {
        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("UPDATE membres SET
		mot_de_passe = :mot_de_passe
		WHERE
		id = :id_utilisateur");

        $requete->bindValue(':id_utilisateur', $id_utilisateur);
        $requete->bindValue(':mot_de_passe', $mdp);

        return $requete->execute();
    }
}

