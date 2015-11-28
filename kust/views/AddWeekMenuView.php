<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-28
 * Time: 20:18
 */

namespace views;

use models\Week;

require_once('kust/models/Week.php');
class AddWeekMenuView
{

    private $weeks = array();
    private $showMenuForm = 'KustAdminView::showMenuForm';
    private $addWeekMenu = 'KustAdminView::addWeekMenu';
    private $clearMenuForm = 'KustAdminView::clearmenuForm';
    private $mon = 'KustAdminView::monday';
    private $tue = 'KustAdminView::tuesday';
    private $wed = 'KustAdminView::wednesday';
    private $thu = 'KustAdminView::thursday';
    private $fri = 'KustAdminView::friday';
    private $monValue = '';
    private $tueValue = '';
    private $wedValue = '';
    private $thuValue = '';
    private $friValue = '';
    private $errorMessage = "";


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
            "<div>
                <form method='post' action=''>
                    <fieldset>
                        <legend>Lägg till veckomeny</legend>
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

    public function saveMenu(){
        if(isset($_POST[$this->addWeekMenu])){
            $this->monValue = strip_tags($_POST[$this->mon]);
            $this->tueValue = strip_tags($_POST[$this->tue]);
            $this->wedValue = strip_tags($_POST[$this->wed]);
            $this->thuValue = strip_tags($_POST[$this->thu]);
            $this->friValue = strip_tags($_POST[$this->fri]);
            return true;
        }
        return false;
    }

    public function showMenuForm(){
        if(isset($_POST[$this->showMenuForm])){
            return true;
        }
        return false;
    }

    private function showErrorMessage(){
        return $this->errorMessage;
    }

    public function setWeeks(){
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