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

    public function __construct($id=0, $week, $monday, $tuesday, $wednesday, $thursday, $friday)
    {
        $this->id = $id;
        $this->week = $week;
        $this->monday = $monday;
        $this->tuesday = $tuesday;
        $this->wednesday = $wednesday;
        $this->thursday = $thursday;
        $this->friday = $friday;
    }

}