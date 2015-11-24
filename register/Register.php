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
    private $databaseTable = "users";
    private $dbConnection;

    public function __construct($mysqli){

        $this->dbConnection = $mysqli;
    }

    public function registerUser($username, $password){

        $query = $this->dbConnection->prepare('SET @username := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $username);
        $query->execute();

        //bind second parameter to session variable @password
        $query = $this->dbConnection->prepare('SET @password := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $password);
        $query->execute();

        //execute stored procedure
        $this->dbConnection->query('call register_user(@username, @password)');
        $this->dbConnection->close();
    }
}