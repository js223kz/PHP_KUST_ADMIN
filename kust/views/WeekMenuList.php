<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-30
 * Time: 13:14
 */

namespace views;

require_once('kust/models/WeekMenuDAL.php');
require_once('kust/models/Week.php');
class WeekMenuList
{
    private static $deleteMenuUrl = 'radera';
    private static $editMenuUrl = 'redigera';
    private static $deleteConfirmed = 'WeekMenuList::DeleteConfirmed';
    private static $cancel = 'WeekMenuList::Cancel';


    public function userWantsToDeleteMenu(){
        if(isset($_GET[self::$deleteMenuUrl])){
            return true;
        }
        return false;
    }

    public function userConfirmsDeleteMenu(){
        if(isset($_POST[self::$deleteConfirmed])){
            header('Location: /');
            return true;
        }
       return false;
    }

    public function userWantsToEditMenu(){
        if(isset($_GET[self::$editMenuUrl])){
            return true;
        }
        return false;
    }

    public function userWantsToCancel(){
        if(isset($_POST[self::$cancel])){
            header('Location: /');
            return true;
        }
        return false;
    }

    public function getDeleteWeekMenuUrl($id){
        return "?".self::$deleteMenuUrl."=$id";
    }

    public function getEditWeekMenuUrl($id){
        return "?".self::$editMenuUrl."=$id";
    }

    public function getId(){
        if(isset($_GET[self::$deleteMenuUrl])){
            return $_GET[self::$deleteMenuUrl];
        }
        if(isset($_GET[self::$editMenuUrl])){
            return $_GET[self::$editMenuUrl];
        }
        return null;
    }




    public function showDeleteView($weekMenues){
        $id = $this->getId();
        $weekNumber = "";
        $ret = "";

        foreach($weekMenues as $menue){
            if($menue->getId() == $id){
                $week = $menue->getWeek();
                $weekNumber = $week->getWeekNumber();
            }
        }

        $ret .=
            "<div>
                <form method='post' action=''>
                    <fieldset>
                        <legend>Säkert att du vill radera veckomenyn för vecka $weekNumber?</legend>
                        <button name='".self::$deleteConfirmed."'>Ja</button>
                        <button name='".self::$cancel."'>Nej</button>
                    </fieldset>
		        </form>
            </div>";

        return $ret;
    }
    public function showWeekMenuList($weekMenues){

        $ret = "<table>";
        foreach($weekMenues as $key => $menu){

            $id = $menu->getId();
            $week = $menu->getWeek();
            $deleteUrl = $this->getDeleteWeekMenuUrl($id);
            $editUrl = $this->getEditWeekMenuUrl($id);
            $ret .=
                " <tr>
                    <th>Vecka | ".$week->getWeekNumber()." | ".$week->getStartDay()." | ".$week->getEndDay()."</th>
                    <th><a href=$editUrl>Redigera</a></th>
                    <th><a href=$deleteUrl>Radera</a></th>
                  </tr>
                  <tr>
                    <td>Måndag  " .$menu->getMonday() ." </td>
                  </tr>
                  <tr>
                    <td>Tisdag  ".$menu->getTuesday()."</td>
                  </tr>
                  <tr>
                    <td>Onsdag  ".$menu->getWednesday()."</td>
                  </tr>
                  <tr>
                    <td>Torsdag  ".$menu->getThursday()."</td>
                  </tr>
                  <tr>
                    <td>Fredag  ".$menu->getFriday()."</td>
                  </tr>";
        }
        $ret .="</table>";
        return $ret;
    }
}
