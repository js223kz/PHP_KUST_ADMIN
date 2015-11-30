<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-29
 * Time: 11:04
 */

namespace models;

require_once('Week.php');
class WeekMenu
{
    private $id;
    private $week;
    private $monday;
    private $tuesday;
    private $wednesday;
    private $thursday;
    private $friday;

    public function __construct($week, $monday, $tuesday, $wednesday, $thursday, $friday)
    {
        //validera fälten
        $this->week = $week;
        $this->monday = $monday;
        $this->tuesday = $tuesday;
        $this->wednesday = $wednesday;
        $this->thursday = $thursday;
        $this->friday = $friday;
    }

    public function setId($id){
        //validera id
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