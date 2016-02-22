<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 11:16
 */
class ParentForum
{
    public $idForum="default";
    public $dateHeureForum="2000-11-11, 22:22";

    public function do_ParentForum()
    {
        echo $this->dateHeureForum;
        echo $this->idForum;
    }

}