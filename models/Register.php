<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-19
 * Time: 12:12
 */

namespace models;


class Register
{
    private static $databaseTable = "users";
    private $dbConnection;

    public function __construct($mysqli){

        $this->dbConnection = $mysqli;
    }

    public function registerUser($username, $Password){

    }
}