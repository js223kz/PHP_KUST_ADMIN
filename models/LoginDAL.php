<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-22
 * Time: 17:47
 */

namespace models;

use commons\DatabaseConnection;
use exceptions\DatabaseErrorException;

require_once('commons/DatabaseConnection.php');
require_once('commons/exceptions/DatabaseErrorException.php');
require_once('models/User.php');

//class that handles user authentication
//and corresponds with database
class LoginDAL
{
    private $dbConnection;
    private static $isUserLoggedIn = 'LoginDAL::isUserLoggedIn';
    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();
    }

    public function tryLogin($user)
    {
        //Set in/out parameters (in username, out password)
        $this->dbConnection->query("SET @username = " . "'" .
            $this->dbConnection->real_escape_string($user->getUsername()) . "'");
        $this->dbConnection->query("SET @password := FALSE");

        //call stored procedure
        if (!$this->dbConnection->query('CALL login(@username, @password)')) {
            throw new DatabaseErrorException($this->dbConnection->error);
        }

        // Fetch OUT parameters
        if (!($res = $this->dbConnection->query("SELECT @password AS password"))) {
            throw new DatabaseErrorException($this->dbConnection->error);
        }

        $row = $res->fetch_assoc();
        $this->dbConnection->close();

        //check hashed password from database against user input
        if ($row['password'] == null) {
            return null;
        } else if (password_verify($user->getPassword(), $row['password'])){
            $_SESSION[self::$isUserLoggedIn] = $user->getUsername();
            return true;
        }else{
            return false;
        }
    }

    public function isUserLoggedIn(){
        if(isset($_SESSION[self::$isUserLoggedIn])){
            return true;
        }
        return false;
    }

    public function unsetSession(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
