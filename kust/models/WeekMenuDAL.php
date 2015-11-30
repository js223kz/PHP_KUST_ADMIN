<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-29
 * Time: 12:00
 */

namespace models;

use commons\DatabaseConnection;

require_once('WeekMenu.php');
require_once('Week.php');
require_once('commons/DatabaseConnection.php');
require_once('commons/exceptions/DatabaseErrorException.php');
class WeekMenuDAL
{

    private $dbConnection;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();
    }


    public function getAllWeekMenues(){
        
    }

    public function saveWeekMenu($weekMenu){

        $weekNumber = $this->dbConnection->real_escape_string($weekMenu->getWeek()->getWeekNumber());
        $startDay = $this->dbConnection->real_escape_string($weekMenu->getWeek()->getStartDay());
        $endDay = $this->dbConnection->real_escape_string($weekMenu->getWeek()->getEndDay());
        $monday =  $this->dbConnection->real_escape_string($weekMenu->getMonday());
        $tuesday =  $this->dbConnection->real_escape_string($weekMenu->getTuesDay());
        $wednesday =  $this->dbConnection->real_escape_string($weekMenu->getWednesday());
        $thursday =  $this->dbConnection->real_escape_string($weekMenu->getThursday());
        $friday =  $this->dbConnection->real_escape_string($weekMenu->getFriday());


        $query = $this->dbConnection->prepare('SET @startDay := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $startDay);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @endDay := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $endDay);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @weekNumber := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('i', $weekNumber);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @monday:= ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $monday);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @tuesday := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $tuesday);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @wednesday := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $wednesday);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @thursday := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $thursday);
        $query->execute();

        $query = $this->dbConnection->prepare('SET @friday := ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('s', $friday);
        $query->execute();

        //execute stored procedure
        $this->dbConnection->query('call save_weekmenu(@startDay, @endDay, @weekNumber, @monday, @tuesday, @wednesday, @thursday, @friday)');
        $this->dbConnection->close();
    }

}