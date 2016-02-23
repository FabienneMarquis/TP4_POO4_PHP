<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 10:52
 */
class Forum
{
    private $ForumID;
    private $titre="deafault title";
    private $horoDate;


    /**
     * Forum constructor.
     * @param $ForumID
     * @param string $titre
     * @param $horoDate
     */
    public function __construct($ForumID, $titre, $horoDate)
    {
        $this->ForumID = $ForumID;
        $this->titre = $titre;
        $this->horoDate = $horoDate;
    }


    /**
     * @return mixed
     */
    public function getForumID()
    {
        return $this->ForumID;
    }

    /**
     * @param mixed $ForumID
     */
    public function setForumID($ForumID)
    {
        $this->ForumID = $ForumID;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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


}
