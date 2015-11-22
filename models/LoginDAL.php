<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-22
 * Time: 17:47
 */

namespace models;

use commons\DatabaseConnection;

require_once('commons/DatabaseConnection.php');
require_once('models/User.php');

class LoginDAL
{
    private $dbConnection;
    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();
    }

    public function tryLogin($user){

        /*$query = $this->dbConnection->prepare('SET @username := ?');
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
        $this->dbConnection->close();*/
    }

}