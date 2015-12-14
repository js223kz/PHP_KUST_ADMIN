<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-30
 * Time: 13:14
 */

namespace views;

require_once('kust/models/Week.php');

/**
 * Class WeekMenuList
 * renders a list of alla weekmenues
 * and handles user interaction concerning
 * that list
 */
class WeekMenuList
{
    private static $deleteMenuUrl = 'radera';
    private static $editMenuUrl = 'redigera';

    public function userWantsToDeleteMenu(){
        if(isset($_GET[self::$deleteMenuUrl])){
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

    public function redirect(){
        header('Location: /');
    }

    //renders list of all weekmenues collected from database
    public function showMenuList($weekMenues){

        //sorts array of weekmenu objects by week startday
        usort($weekMenues, function($a, $b) {
            return $a->getWeek()->getStartDay() > $b->getWeek()->getStartDay();
        });

        $ret = "<div class='menulist'>
                 <table>";

        foreach($weekMenues as $key => $menu){

            $id = $menu->getId();
            $week = $menu->getWeek();
            $deleteUrl = $this->getDeleteWeekMenuUrl($id);
            $editUrl = $this->getEditWeekMenuUrl($id);
            $ret .=
                "<tr>
                    <th class='menulistheader'>Vecka | ".$week->getWeekNumber()." | ".$week->getStartDay()." | ".$week->getEndDay()."</th>
                    <th><a class='headerlink'href=$editUrl>REDIGERA</a></th>
                    <th><a class='headerlink' href=$deleteUrl>RADERA</a></th>
                  </tr>
                  <tr>
                    <td class='menutext' colspan='3'>Måndag:  " .$menu->getMonday() ." </td>
                  </tr>
                  <tr>
                    <td class='menutext' colspan='3'>Tisdag:  ".$menu->getTuesday()."</td>
                  </tr>
                  <tr>
                    <td class='menutext' colspan='3'>Onsdag:  ".$menu->getWednesday()."</td>
                  </tr>
                  <tr>
                    <td class='menutext' colspan='3'>Torsdag:  ".$menu->getThursday()."</td>
                  </tr>
                  <tr>
                    <td class='menutext' colspan='3'>Fredag:  ".$menu->getFriday()."</td>
                  </tr>";
        }
        $ret .= "</table>
                </div>";
        return $ret;
    }
}
