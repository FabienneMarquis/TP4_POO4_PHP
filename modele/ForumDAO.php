<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 11:29
 */
class ForumDAO
{
    public static function getForums()
    {
        $pdo = PDO2::getInstance();

        $requete = $pdo->prepare("SELECT * FROM forum");

        $requete->execute();
        $forums = array();
        while($result = $requete->fetch(PDO::FETCH_ASSOC)) {
            $forums[$result['ForumID']] = new Forum($result['ForumID'],$result['titre'],$result['horoDate']);;
        }
        $requete->closeCursor();
        return $forums;
    }
}