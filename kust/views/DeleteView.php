<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-12-14
 * Time: 16:52
 */

namespace views;

use commons\SecurityToken;

require_once('kust/views/WeekMenuList.php');
require_once('commons/SecurityToken.php');

/**
 * Class DeleteView
 * @package views
 * renders a partial delete view and
 * handles user interaction concerning those actions
 */
class DeleteView
{
    private static $deleteConfirmed = 'WeekMenuList::DeleteConfirmed';
    private static $cancel = 'WeekMenuList::Cancel';
    private static $validationToken = 'DeleteView::validationToken';
    private $formName = 'formname';
    private $securityToken;
    private $menuListView;

    public function __construct()
    {
        $this->securityToken = new SecurityToken();
        $this->menuListView = new WeekMenuList();
    }

    public function userConfirmsDeleteMenu(){
        if(isset($_POST[self::$deleteConfirmed])){
            $this->menuListView->redirect();
            return true;
        }
        return false;
    }

    public function cancelDelete(){
        if(isset($_POST[self::$cancel])){
            $this->menuListView->redirect();
        }
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

    public function showDeleteView($weekMenues, $id){
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
                <form name=".$this->formName." class='deleteform' method='post' action=''>
                    <fieldset class='deleteweekmenufieldset'>
                        <legend>SÄKERT ATT DU VILL RADERA VECKOMENY FÖR VECKA $weekNumber?</legend>
                        <input type='hidden' name=".self::$validationToken." value=".$this->securityToken->generateToken($this->formName)." />
                        <button class='btn' name='".self::$deleteConfirmed."'>Ja</button>
                        <button class='btn' name='".self::$cancel."'>Nej</button>
                    </fieldset>
		        </form>
            </div>";

        return $ret;
    }
}