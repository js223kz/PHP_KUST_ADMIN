<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-29
 * Time: 11:04
 */

namespace models;

use exceptions\NotValidWeekObject;

require_once('Week.php');

//class that creates weekmenu object to
//be stored in database
class WeekMenu
{
    private $id;
    private $week;
    private $monday;
    private $tuesday;
    private $wednesday;
    private $thursday;
    private $friday;

    public function __construct($id, $week, $monday, $tuesday,
                                $wednesday, $thursday, $friday){
        if(!empty($id) || !empty($week) || !empty($monday || !empty($tuesday)
                || !empty($wednesday) || !empty($thursday) || !empty($friday))){

            //id can be set to 0 if object is created for the first time
            $this->id = $id;
            $this->week = $week;
            $this->monday = $monday;
            $this->tuesday = $tuesday;
            $this->wednesday = $wednesday;
            $this->thursday = $thursday;
            $this->friday = $friday;
        }else{
            throw new NotValidWeekObject();
        }
    }
    //Sets Object id to be same as primary key
    //when object are selected from database
    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function getWeek(){
        return $this->week;
    }

    public function getMonday(){
        return $this->monday;
    }

    public function getTuesday(){
        return $this->tuesday;
    }

    public function getWednesday(){
        return $this->wednesday;
    }

    public function getThursday(){
        return $this->thursday;
    }

    public function getFriday(){
        return $this->friday;
    }

}