<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 11:29
 */
class MessageDAO
{
    public static function getMessagesForForum($ForumID)
    {
        $requete = PDO2::getInstance()->prepare('select * from `message` where forum_ForumID = :forum_ForumID and parent_messageID IS NULL order by horoDate');
        $requete->bindValue(':forum_ForumID', $ForumID);

        $requete->execute();
        while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
            $results[$result['messageID']] = new Message($result['messageID'], $result['membres_id'], $result['parent_messageID'], $result['horoDate'], $result['forum_ForumID'], $result['texte']);
        }
        return empty($results) ? false : $results;
    }

    public static function createMessage(Message $message)
    {
        $requete = PDO2::getInstance()->prepare('insert into message set membres_id = :membres_id , parent_messageID = :parent_messageID, horoDate = NOW(), forum_ForumID = :forum_ForumID, texte = :texte');
        $requete->bindValue(':membres_id', $message->getMembresId());
        $requete->bindValue(':parent_messageID', $message->getParentMessageID()!=='NULL'?$message->getParentMessageID():NULL);
        $requete->bindValue(':forum_ForumID', $message->getForumForumID());
        $requete->bindValue(':texte', $message->getTexte());

        return $requete->execute();

    }

    public static function getMessagesForMessage($parent_messageID){
        $requete = PDO2::getInstance()->prepare('select * from `message` where parent_messageID = :parent_messageID order by horoDate');
        $requete->bindValue(':parent_messageID', $parent_messageID);

        $requete->execute();
        while ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
            $results[$result['messageID']] = new Message($result['messageID'], $result['membres_id'], $result['parent_messageID'], $result['horoDate'], $result['forum_ForumID'], $result['texte']);
        }
        return empty($results) ? false : $results;
    }


}