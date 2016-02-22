<?php

/**
 * Created by PhpStorm.
 * User: 1494778
 * Date: 2016-02-09
 * Time: 11:29
 */
class ForumDAO
{
    public function getForums()
    {
        session_start();
        try {
            idcom :
            new PDO('mysql:host=localhost;dbname=bd stagiaires;charset=utf8',
                'root', '');
        } catch (Exception $e) {
            die ('Erreur : ' . $e->getMessage());
        }
    }
}