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
class AddWeekMenuView
{

    private $weeks = array();
    private $showMenuForm = 'KustAdminView::showMenuForm';
    private $addWeekMenu = 'KustAdminView::addWeekMenu';
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
    private $selectedWeekValue = '';


    public function __construct()
    {
        $this->setWeeks();
    }

    public function renderAddWeekMenuButton(){
        if(isset($_SESSION['test'])){
            var_dump($_SESSION['test']);
        }
        $ret = "";
        $ret .= "<div>";
        $ret .= " <form method='post' action=''>
                     <button name=$this->showMenuForm>Lägg till veckomeny</button>
                 </form>";

        $ret .= "</div>";
        return $ret;
    }

    public function renderAddWeekMenuForm(){
        $ret = "";
        $ret .=
            "<div id='menuform'>
                <form method='post' action=''>
                    <fieldset>
                        <legend>Lägg till veckomeny</legend>
                        ".$this->populateDropDownList()."
                        <input type='text' name=$this->mon placeholder='Måndag' value='$this->monValue' size='100' required/> </br>
                        <input type='text' name=$this->tue placeholder='Tisdag' value='$this->tueValue' size='100' required/> </br>
                        <input type='text' name=$this->wed placeholder='Onsdag' value='$this->wedValue' size='100' required/> </br>
                        <input type='text' name=$this->thu placeholder='Torsdag'value='$this->thuValue' size='100' required/> </br>
                        <input type='text' name=$this->fri placeholder='Fredag' value='$this->friValue' size='100' required/> </br>
                        <input type='submit' name=$this->addWeekMenu value='Spara'/>
                        <input type='reset' name=$this->addWeekMenu value='Rensa'/>
                    </fieldset>
                </form>
		   </div>";
        return $ret;
    }

    public function userWantsToSaveMenu(){
        if(isset($_POST[$this->addWeekMenu])){
            return true;
        }
        return false;
    }

    public function getWeekMenuToSave(){
        $this->selectedWeekValue = strip_tags($_POST[$this->weekDropDown]);
        $this->monValue = strip_tags($_POST[$this->mon]);
        $this->tueValue = strip_tags($_POST[$this->tue]);
        $this->wedValue = strip_tags($_POST[$this->wed]);
        $this->thuValue = strip_tags($_POST[$this->thu]);
        $this->friValue = strip_tags($_POST[$this->fri]);

        foreach($this->weeks as $week){
            if($week->getStartDay() == $this->selectedWeekValue){
                return new WeekMenu($week, $this->monValue, $this->tueValue, $this->wedValue, $this->thuValue, $this->friValue);
            }
        }
        return null;
    }

    public function showMenuForm(){
        if(isset($_POST[$this->showMenuForm])){
            return true;
        }
        return false;
    }

    private function populateDropDownList(){
        $ret = "";
        $ret .= "<select name=$this->weekDropDown required>";
        $ret .= "<option selected disabled>Välj vecka</option>";

        foreach($this->weeks as $week){
            $value =  $week->getWeekNumber() . ' | ' . $week->getStartDay() . ' | ' . $week->getEndDay();
            $ret .= "<option name=".$week->getStartDay().">$value</option>";
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