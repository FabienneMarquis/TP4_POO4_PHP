<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-22
 * Time: 15:24
 */

echo '<p>Votre Nom: '.$_SESSION['user']->getName().'</p>';
echo '<p>Votre Email: '.$_SESSION['user']->getEmail().'</p>';
echo '<p>Votre Date d\'inscription: '.$_SESSION['user']->getInscriptionDate().'</p>';
echo '<p>Votre Avatar: '.$_SESSION['user']->getAvatar().'</p>';