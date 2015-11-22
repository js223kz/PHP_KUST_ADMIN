<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-19
 * Time: 12:21
 */

namespace models;


class User
{
    private $userName;
    private $passWord;

    public function __construct($username, $password)
    {
       trim($username);
       trim($password);

        if(empty($userName)){
            throw new \Exception("Användarnamn saknas");
        }
        if(empty($passWord)){
            throw new \Exception("Lösenord saknas");
        }
        if(mb_strlen($username) != mb_strlen(strip_tags($username)) ||
            mb_strlen($password) != mb_strlen(strip_tags($password))){
            throw new \Exception("Otillåtna tecken");
        }

        $this->userName = $username;
        $this->passWord = $password;
    }
}