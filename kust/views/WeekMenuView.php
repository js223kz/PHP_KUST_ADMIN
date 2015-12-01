<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-28
 * Time: 20:18
 */

namespace views;

use models\Week;
use models\WeekMenu;

require_once('kust/models/Week.php');
require_once('kust/models/WeekMenu.php');
class WeekMenuView
{

    private $weeks = array();
    private $showMenuForm = 'KustAdminView::showMenuForm';
    private static $addWeekMenu = 'KustAdminView::addWeekMenu';
    private static $updateWeekMenu = 'KustAdminView::updateWeekMenu';
    private static $cancelUpdate = 'KustAdminView::cancelUpdate';
    private static $id = 'KustAdminView::id';
    private $mon = 'KustAdminView::monday';
    private $tue = 'KustAdminView::tuesday';
    private $wed = 'KustAdminView::wednesday';
    private $thu = 'KustAdminView::thursday';
    private $fri = 'KustAdminView::friday';
    private $weekDropDown = 'KustAdminView::weekDropDown';
    private $monValue = '';
    private $tueValue = '';
    private $wedValue = '';
    private $thuValue = '';
    private $friValue = '';
    private $weekId = '';


    public function __construct()
    {
        $this->setWeeks();
    }

    public function userWantsToSaveMenu(){
        if(isset($_POST[self::$addWeekMenu])){
            header('Location: /');
            return true;
        }
        return false;
    }

    public function userWantsUpdateMenu(){
        if(isset($_POST[self::$updateWeekMenu])){
            return true;
        }
        return false;
    }

    public function userWantsToCancelUpdate(){
        if(isset($_POST[self::$cancelUpdate])){
            header('Location: /');
            return true;
        }
        return false;
    }

    public function renderAddWeekMenuButton(){
        $ret = "";
        $ret .= "<div>";
        $ret .= " <form method='post' action=''>
                     <button name=$this->showMenuForm>Lägg till veckomeny</button>
                 </form>";

        $ret .= "</div>";
        return $ret;
    }

    public function renderInputFields($menu = null){
        if($menu != null){
            $this->weekId = $menu->getId();
            $this->monValue = $menu->getMonday();
            $this->tueValue = $menu->getTuesday();
            $this->wedValue = $menu->getWednesday();
            $this->thuValue = $menu->getThursday();
            $this->friValue = $menu->getFriday();
        }

        $ret = "";
        $ret .=
            "
            <input type='text' name=$this->mon placeholder='Måndag' value='$this->monValue' size='100' required/> </br>
            <input type='text' name=$this->tue placeholder='Tisdag' value='$this->tueValue' size='100' required/> </br>
            <input type='text' name=$this->wed placeholder='Onsdag' value='$this->wedValue' size='100' required/> </br>
            <input type='text' name=$this->thu placeholder='Torsdag'value='$this->thuValue' size='100' required/> </br>
            <input type='text' name=$this->fri placeholder='Fredag' value='$this->friValue' size='100' required/> </br>";
        return $ret;
    }

    public function renderAddMenuForm(){
        $ret = "";
        $ret .=
            "<div id='menuform'>
                <form method='post' action=''>
                    <fieldset>
                        <legend>Lägg till veckomeny</legend>
                        ".$this->populateDropDownList()."
                        ".$this->renderInputFields()."

                        <input type='submit' name=".self::$addWeekMenu." value='Spara'/>
                        <input type='reset' value='Rensa'/>
                    </fieldset>
                </form>
            </div>";

        return $ret;
    }

    public function renderEditMenuForm($menu){
        $week = $menu->getWeek();
        $id = $menu->getId();
        $selected = $week->getStartDay();
        $ret = "";
        $ret .=
            "<div id='menuform'>
                <form method='post' action=''>
                    <fieldset>
                        <legend>Redigera veckomeny</legend>
                        ".$this->populateDropDownList($selected)."
                        ".$this->renderInputFields($menu)."
                        <input type='hidden' name=".self::$id." value='$id'/>
                        <input type='submit' name=".self::$updateWeekMenu." value='Spara'/>
                        <input type='submit' name=".self::$cancelUpdate." value='Ångra'/>
                    </fieldset>
                </form>
            </div>";

        return $ret;
    }


    public function getMenu(){
        $id = 0;

        if(isset($_POST[self::$id])){
            $id = strip_tags($_POST[self::$id]);
        }

        $this->selectedWeekValue = strip_tags($_POST[$this->weekDropDown]);
        $this->monValue = strip_tags($_POST[$this->mon]);
        $this->tueValue = strip_tags($_POST[$this->tue]);
        $this->wedValue = strip_tags($_POST[$this->wed]);
        $this->thuValue = strip_tags($_POST[$this->thu]);
        $this->friValue = strip_tags($_POST[$this->fri]);
        $weekMenu = null;
        $startday = substr($this->selectedWeekValue, 5, 10);

        foreach($this->weeks as $week){
            if($week->getStartDay() == $startday){

                $weekMenu = new WeekMenu($id, $week, $this->monValue, $this->tueValue, $this->wedValue, $this->thuValue, $this->friValue);
            }
        }
        return $weekMenu;
    }

    public function showMenuForm(){
        return isset($_POST[$this->showMenuForm]);
    }

    private function populateDropDownList($selected = null){
        $ret = "";
        $ret .= "<select name=$this->weekDropDown required>";
        $ret .= "<option selected disabled>Välj vecka</option>";

        foreach($this->weeks as $week){
            $value =  $week->getWeekNumber() . ' | ' . $week->getStartDay() . ' | ' . $week->getEndDay();

            if($selected != null && $selected == $week->getStartDay()){
                $ret .= "<option selected name=".$week->getStartDay()." >$value</option>";
            }else{
                $ret .= "<option name=".$week->getStartDay().">$value</option>";
            }

        }
        $ret .="</select>";

        return $ret;
    }

    private function setWeeks(){
        date_default_timezone_set("Europe/Stockholm");
        $start_date  = new \DateTime();
        $interval    = new \DateInterval('P1W');
        $recurrences = 53;

        foreach (new \DatePeriod($start_date, $interval, $recurrences) as $date) {
            $weekNumber = $date->format('W');
            $endDay = $date->modify('Monday this week')->format('Y-m-d');
            $startDay = $date->modify('Friday this week')->format('Y-m-d');
            $week = new Week($weekNumber, $endDay, $startDay);

            array_push($this->weeks, $week);
        }
    }
}