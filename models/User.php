<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-19
 * Time: 12:21
 */

namespace models;
use exceptions\EmptyPasswordException;
use exceptions\EmptyUsernameException;
use exceptions\NotAllowedException;

require_once('commons/exceptions/EmptyPasswordException.php');
require_once('commons/exceptions/EmptyUsernameException.php');
require_once('commons/exceptions/NotAllowedException.php');


class User
{
    private $userName;
    private $passWord;

    public function __construct($username, $password)
    {
       trim($username);
       trim($password);

        if(empty($username)){
            throw new EmptyUsernameException;
        }
        if(empty($password)){
            throw new EmptyPasswordException;
        }
        if(mb_strlen($username) != mb_strlen(strip_tags($username)) ||
            mb_strlen($password) != mb_strlen(strip_tags($password))){
            throw new NotAllowedException;
        }

        $this->userName = $username;
        $this->passWord = $password;
    }

    public function getUsername(){
        return $this->userName;
    }
    public function getPassword(){
        return $this->passWord;
    }
}