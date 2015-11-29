<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-29
 * Time: 12:00
 */

namespace models;

require_once('WeekMenu.php');
require_once('Week.php');
class WeekMenuDAL
{



    public function saveWeekMenu($weekMenu){

        $weekNumber = $weekMenu->getWeek()->getWeekNumber();
        $startDay = $weekMenu->getWeek()->getStartDay();
        $endDay = $weekMenu->getWeek()->getEndDay();
        $monday = $weekMenu->getMonday();
        $tuesday = $weekMenu->getTuesDay();
        $wednesday = $weekMenu->getWednesday();
        $thursday = $weekMenu->getThursday();
        $friday = $weekMenu->getFriday();

        $query = $this->dbConnection->prepare('SET @startDay := ?');
        $query = $this->dbConnection->prepare('SET @endDay := ?');
        $query = $this->dbConnection->prepare('SET @weekNumber := ?');
        $query = $this->dbConnection->prepare('SET @monday:= ?');
        $query = $this->dbConnection->prepare('SET @tuesday := ?');
        $query = $this->dbConnection->prepare('SET @wednesday := ?');
        $query = $this->dbConnection->prepare('SET @thursday := ?');
        $query = $this->dbConnection->prepare('SET @friday := ?');

        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param('ssisssss', $startDay, $endDay, $weekNumber, $monday, $tuesday, $wednesday, $thursday, $friday);
        $query->execute();


        //execute stored procedure
        $this->dbConnection->query('call register_user(@startDay, @endDay, @weekNumber, @monday, @tuesday, @wednesday, @thursday, @friday)');
        $this->dbConnection->close();
    }

}