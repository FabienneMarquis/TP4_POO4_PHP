<?php
/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 10:44
 */

class Message
{
    private $messageID;
    private $membres_id;
    private $parent_messageID;
    private $horoDate;
    private $forum_ForumID;
    private $texte;

    /**
     * Message constructor.
     * @param $messageID
     * @param $membres_id
     * @param $parent_messageID
     * @param $horoDate
     * @param $forum_ForumID
     * @param $texte
     */
    public function __construct($messageID, $membres_id, $parent_messageID, $horoDate, $forum_ForumID, $texte)
    {
        $this->messageID = $messageID;
        $this->membres_id = $membres_id;
        $this->parent_messageID = $parent_messageID;
        $this->horoDate = $horoDate;
        $this->forum_ForumID = $forum_ForumID;
        $this->texte = $texte;
    }

    /**
     * @return mixed
     */
    public function getMessageID()
    {
        return $this->messageID;
    }

    /**
     * @param mixed $messageID
     */
    public function setMessageID($messageID)
    {
        $this->messageID = $messageID;
    }

    /**
     * @return mixed
     */
    public function getMembresId()
    {
        return $this->membres_id;
    }

    /**
     * @param mixed $membres_id
     */
    public function setMembresId($membres_id)
    {
        $this->membres_id = $membres_id;
    }

    /**
     * @return mixed
     */
    public function getParentMessageID()
    {
        return $this->parent_messageID;
    }

    /**
     * @param mixed $parent_messageID
     */
    public function setParentMessageID($parent_messageID)
    {
        $this->parent_messageID = $parent_messageID;
    }

    /**
     * @return mixed
     */
    public function getHoroDate()
    {
        return $this->horoDate;
    }

    /**
     * @param mixed $horoDate
     */
    public function setHoroDate($horoDate)
    {
        $this->horoDate = $horoDate;
    }

    /**
     * @return mixed
     */
    public function getForumForumID()
    {
        return $this->forum_ForumID;
    }

    /**
     * @param mixed $forum_ForumID
     */
    public function setForumForumID($forum_ForumID)
    {
        $this->forum_ForumID = $forum_ForumID;
    }

    /**
     * @return mixed
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param mixed $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }


}
?>