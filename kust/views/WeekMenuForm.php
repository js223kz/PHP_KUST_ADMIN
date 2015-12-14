<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-28
 * Time: 20:18
 */

namespace views;

use commons\SecurityToken;
use exceptions\NotValidWeekObject;
use models\Week;
use models\WeekMenu;

require_once('kust/models/Week.php');
require_once('kust/models/WeekMenu.php');
require_once('commons/SecurityToken.php');

/**
 * Class WeekMenuForm
 * @package views
 * renders a partial view for adding or
 * editing a weekmenu and handles all
 * events concerning those actions
 */

class WeekMenuForm
{
    private $weeks = array();
    private $showMenuForm = 'KustAdminView::showMenuForm';
    private static $addWeekMenu = 'KustAdminView::addWeekMenu';
    private static $updateWeekMenu = 'KustAdminView::updateWeekMenu';
    private static $cancelUpdate = 'KustAdminView::cancelUpdate';
    private static $validationToken = 'KustAdminView::validationToken';
    private static $id = 'KustAdminView::id';
    private static $mon = 'KustAdminView::monday';
    private static $tue = 'KustAdminView::tuesday';
    private static $wed = 'KustAdminView::wednesday';
    private static $thu = 'KustAdminView::thursday';
    private static $fri = 'KustAdminView::friday';
    private static $weekDropDown = 'KustAdminView::weekDropDown';
    private $formName = 'formname';
    private $monValue = '';
    private $tueValue = '';
    private $wedValue = '';
    private $thuValue = '';
    private $friValue = '';
    private $weekId = '';
    private $errorMessage;
    private $securityToken;

    public function __construct()
    {
        $this->setWeeks();
        $this->securityToken = new SecurityToken();
    }

    public function redirect(){
        header('Location: /');
    }

    public function userWantsToSaveMenu(){
        if(isset($_POST[self::$addWeekMenu])){
            $this->redirect();
            return true;
        }
        return false;
    }

    public function userWantsUpdateMenu(){
        if(isset($_POST[self::$updateWeekMenu])){
            $this->redirect();
            return true;
        }
        return false;
    }

    public function cancelUpdate(){
        if(isset($_POST[self::$cancelUpdate])){
            $this->redirect();
        }
    }

    public function showMenuForm(){
        return isset($_POST[$this->showMenuForm]);
    }

    public function setDatabaseErrorMessage(){
        $this->errorMessage = "Något gick fel med kontakten till databasen. Försök igen.";
    }

    private function setInvalidObjectErrorMessage($message){
        $this->errorMessage = "Alla fält måste vara ifyllda.";
    }

    private function getErrorMessage(){
        return $this->errorMessage;
    }

    public function renderAddWeekMenuButton(){
        $ret = "";
        $ret .= "<div class='addmenubuttoncontainer'>";
        $ret .= " <form method='post' action=''>
                     <button class='addmenubutton' name=$this->showMenuForm>Lägg till veckomeny</button>
                 </form>";

        $ret .= "</div>";
        return $ret;
    }

    //checks for a valid token before deleting menu
    //token is generated and checked in commons/SecurityToken.php
    public function isTokenValid(){
        if(isset($_POST[self::$validationToken])){
            if($this->securityToken->checkToken($_POST[self::$validationToken], $this->formName)) {
                return true;
            }
        }
        return false;
    }

    private function renderInputFields($menu = null){
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
            <input type='text' name=".self::$mon." placeholder='Måndag' value='$this->monValue' class='menuinput' required/> </br>
            <input type='text' name=".self::$tue." placeholder='Tisdag' value='$this->tueValue' class='menuinput' required/> </br>
            <input type='text' name=".self::$wed." placeholder='Onsdag' value='$this->wedValue' class='menuinput' required/> </br>
            <input type='text' name=".self::$thu." placeholder='Torsdag'value='$this->thuValue' class='menuinput' required/> </br>
            <input type='text' name=".self::$fri." placeholder='Fredag' value='$this->friValue' class='menuinput' required/> </br>";
        return $ret;
    }

    public function renderAddMenuForm($weekMenues){
        $ret =
            "<div class='menuform'>
                <form name=".$this->formName." method='post' action=''>
                    <fieldset class='addweekmenufieldset'>
                        <legend>LÄGG TILL VECKOMENY</legend>
                        <p>".$this->getErrorMessage()."</p>
                        ".$this->populateAddDropDown($weekMenues)."
                        ".$this->renderInputFields()."
                        <input type='hidden' name=".self::$validationToken." value=".$this->securityToken->generateToken($this->formName)." />
                        <input class='btn' type='submit' name=".self::$addWeekMenu." value='Spara'/>
                        <input class='btn' type='reset' value='Rensa'/>
                    </fieldset>
                </form>
            </div>";

        return $ret;
    }

    public function renderEditMenuForm($weekMenues, $menuToEdit){
        $week = $menuToEdit->getWeek();
        $id = $menuToEdit->getId();
        $selected = $week->getStartDay();
        $ret =
            "<div class='menuform'>
                <form name=".$this->formName." method='post' action=''>
                    <fieldset class='addweekmenufieldset'>
                        <legend>REDIGERA VECKOMENY</legend>
                         <p>".$this->getErrorMessage()."</p>
                        ".$this->populateEditDropDown($selected, $menuToEdit, $weekMenues)."
                        ".$this->renderInputFields($menuToEdit)."
                        <input type='hidden' name=".self::$validationToken." value=".$this->securityToken->generateToken($this->formName)." />
                        <input type='hidden' name=".self::$id." value='$id'/>
                        <input class='btn' type='submit' name=".self::$updateWeekMenu." value='Spara'/>
                        <input class='btn' type='submit' name=".self::$cancelUpdate." value='Ångra'/>
                    </fieldset>
                </form>
            </div>";

        return $ret;
    }


    public function getMenu(){
        //sets id to 0 when created and saved to database
        //when objects are retrieved from database id id
        //set to primary key
        $id = 0;

        if(isset($_POST[self::$id])){
            $id = strip_tags($_POST[self::$id]);
        }

        $this->selectedWeekValue = strip_tags($_POST[self::$weekDropDown]);
        $this->monValue = strip_tags($_POST[self::$mon]);
        $this->tueValue = strip_tags($_POST[self::$tue]);
        $this->wedValue = strip_tags($_POST[self::$wed]);
        $this->thuValue = strip_tags($_POST[self::$thu]);
        $this->friValue = strip_tags($_POST[self::$fri]);
        $weekMenu = null;
        $startday = substr($this->selectedWeekValue, 5, 10);

        foreach($this->weeks as $week){
            if($week->getStartDay() == $startday){

                try{
                    $weekMenu = new WeekMenu($id, $week, $this->monValue, $this->tueValue, $this->wedValue, $this->thuValue, $this->friValue);
                }catch (NotValidWeekObject $e){
                    $this->setInvalidObjectErrorMessage();
                }

            }
        }
        return $weekMenu;
    }

    private function populateAddDropDown($weekMenues){
        $ret = "";
        $ret .= "<select name=".self::$weekDropDown." required>";
        $ret .= "<option selected disabled>Välj vecka</option>";
        $startDays = array();

        foreach($weekMenues as $menu){
            array_push($startDays, $menu->getWeek()->getStartDay());
        }

        foreach($this->weeks as $week){
            if(!in_array($week->getStartDay(), $startDays)){
                $value =  $week->getWeekNumber() . ' | ' . $week->getStartDay() . ' | ' . $week->getEndDay();
                $ret .= "<option name=".$week->getStartDay().">$value</option>";
            }
        }
        $ret .="</select>";

        return $ret;
    }

    private function populateEditDropDown($selected, $menuToEdit, $weekMenues){
        $ret = "";
        $ret .= "<select name=".self::$weekDropDown." required>";
        $ret .= "<option selected disabled>Välj vecka</option>";
        $startDays = array();

        foreach($weekMenues as $menu){
            if($menuToEdit->getWeek()->getStartDay() != $menu->getWeek()->getStartDay()){
                array_push($startDays, $menu->getWeek()->getStartDay());
            }
        }

        foreach($this->weeks as $week){
            if(!in_array($week->getStartDay(), $startDays)){
                $value =  $week->getWeekNumber() . ' | ' . $week->getStartDay() . ' | ' . $week->getEndDay();

                if($selected != null && $selected == $week->getStartDay()){
                    $ret .= "<option selected name=".$week->getStartDay()." >$value</option>";
                }else{
                    $ret .= "<option name=".$week->getStartDay().">$value</option>";
                }
            }
        }
        $ret .="</select>";

        return $ret;
    }

    //set an array with weeks, 53 weeks from today
    //to avoid having already passed weeks in array
    private function setWeeks(){
        date_default_timezone_set("Europe/Stockholm");
        $start_date  = new \DateTime();
        $interval    = new \DateInterval('P1W');
        $recurrences = 53;

        foreach (new \DatePeriod($start_date, $interval, $recurrences) as $date) {
            $weekNumber = $date->format('W');
            $endDay = $date->modify('Friday this week')->format('Y-m-d');
            $startDay = $date->modify('Monday this week')->format('Y-m-d');
            $week = new Week($weekNumber, $startDay, $endDay);

            array_push($this->weeks, $week);
        }
    }
}