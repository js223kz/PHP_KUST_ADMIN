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
    $this->userName = $username;
    $this->passWord = $password;
}

}