<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-29
 * Time: 12:00
 */

namespace models;

use commons\DatabaseConnection;
use exceptions\DatabaseErrorException;

require_once('WeekMenu.php');
require_once('Week.php');
require_once('commons/DatabaseConnection.php');
require_once('commons/exceptions/DatabaseErrorException.php');
class WeekMenuDAL
{

    public function getAllWeekMenues(){

        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();

        $weekMenues = array();
        $query = $this->dbConnection->prepare("CALL select_all()");
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->execute();
        $query->bind_result($id, $object);
        while ($query->fetch()) {
            $weekMenu = unserialize($object);
            $weekMenu->setId($id);
            array_push($weekMenues, $weekMenu);
        }
        $this->dbConnection->close();
        return $weekMenues;
    }

    public function saveWeekMenu($newWeekMenu){
        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();

        $weekMenu = serialize($newWeekMenu);
        try {
            $this->prepareStatement('@weekMenu', 's', $weekMenu);
        }
        catch(\Exception $e){
            throw new DatabaseErrorException($e->getMessage());
        }
        if(!$query = $this->dbConnection->query('call save_weekmenu(@weekMenu)')){
            throw new DatabaseErrorException($this->dbConnection->error);
        }
        $this->dbConnection->close();
    }

    public function getMenuById($id){

        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();

        $query = $this->dbConnection->prepare('CALL get_by_id(?,  @out_id, @out_object)');
        $query->bind_param('i', $id);
        $query->execute();

        $select = $this->dbConnection->query('SELECT @out_id, @out_object');
        $result = $select->fetch_assoc();

        $weekMenu = unserialize($result['@out_object']);
        $weekMenu->setId($result['@out_id']);

        return $weekMenu;
    }


    public function updateMenu($menu){
        var_dump($menu->getId());
    }

    public function deleteWeekMenu($id){
        $db = new DatabaseConnection();
        $this->dbConnection = $db->dbConnection();

       $this->prepareStatement('@id', 'i', $id);

        if (!$this->dbConnection->query('CALL delete_by_id(@id)')) {
            throw new DatabaseErrorException($this->dbConnection->error);

        }
        $this->dbConnection->close();
    }

    //prepare and bind insert parameter
    private function prepareStatement($paramName, $paramType, $value){
        $query = $this->dbConnection->prepare('SET' . $paramName .  ':= ?');
        if ($query === FALSE) {
            throw new \Exception($this->database->error);
        }
        $query->bind_param($paramType, $value);
        $query->execute();
    }

}