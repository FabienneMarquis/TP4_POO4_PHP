<?php
/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 10:44
 */

class Message extends ParentForum
{
    public $idMessage="default";//link with Base de donnée
    public $textMessage="default Text";
    public $nomUtilisateur="John";

    /**
     * Message constructor.
     */
    public function __construct()
    {
        echo $this->idMessage;
        echo $this->textMessage;
        echo $this->nomUtilisateur;
    }

    function do_message()
    {
        echo $this->idMessage;
        echo $this->textMessage;
        echo $this->dateHeureMessage;
        echo $this->idForum;
        echo $this->nomUtilisateur;

    }

}

$bar = new Message;
$bar->do_message();
?>