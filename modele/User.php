<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-22
 * Time: 14:42
 */

class User {

    private $id;
    private $name;
    private $password;
    private $email;
    private $inscriptionDate;
    private $avatar;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    /**
     * @param mixed $inscriptionDate
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * User constructor.
     * @param $name
     * @param $password
     * @param $email
     * @param $inscriptionDate
     * @param $avatar
     */
    public function __construct($name, $password, $email, $inscriptionDate, $avatar)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->inscriptionDate = $inscriptionDate;
        $this->avatar = $avatar;
    }


}