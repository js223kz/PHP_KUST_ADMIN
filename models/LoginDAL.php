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
        $username = $user->getUsername();
        $password =$user->getPassword();
        var_dump($username);

        $this->dbConnection->query("SET @username = " . "'" . $this->dbConnection->real_escape_string($username) . "'");
        $this->dbConnection->query("SET @result := FALSE");

        if(!$this->dbConnection->query('CALL login(@username, @result)')){
            die("CALL failed: (" . $this->dbConnection->errno . ") " . $this->dbConnection->error);
        }

        // Fetch OUT parameters
        if (!($res = $this->dbConnection->query("SELECT @result AS result"))){
            die("Fetch failed: (" .$this->dbConnection->errno . ") " . $this->dbConnection->error);
        }

        $row = $res->fetch_assoc();
        $this->dbConnection->close();

        if(password_verify($password, $row['result'])){
            return true;
        }else{
            return false;
        }


    }

    private function hashPassword($password)
    {
        $options = [
            'cost' => 9,
        ];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);//can return null
        return $password;
    }

}