<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-28
 * Time: 15:12
 */

namespace models;

//class that takes values from drop down list
//creates a week object to be used in a WeekMenu object
class Week
{
    private $weekNumber;
    private $startDay;
    private $endDay;

    public function __construct($weekNumber, $startDay, $endDay)
    {
        $this->weekNumber = $weekNumber;
        $this->startDay = $startDay;
        $this->endDay = $endDay;
    }

    public function getWeekNumber(){
        return $this->weekNumber;
    }

    public function getStartDay(){
        return $this->startDay;
    }

    public function getEndDay(){
        return $this->endDay;
    }
}