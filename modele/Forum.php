<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 10:52
 */
class Forum extends ParentForum
{
    public $titreForum="deafault title";

    public function do_forum()
    {
        echo $this->titreForum;
        echo $this->dateHeureForum;
        echo $this->idForum;
    }
}

?>
}