<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-23
 * Time: 11:19
 */

namespace controllers;
use exceptions\DatabaseErrorException;
use models\WeekMenuDAL;
use views\KustListView;
use views\WeekMenuList;
use views\WeekMenuView;

require_once('models/LoginDAL.php');
require_once('kust/models/WeekMenuDAL.php');
require_once('kust/views/WeekMenuView.php');
require_once('kust/views/WeekMenuList.php');
require_once('views/MasterView.php');
require_once('views/LoginView.php');

class KustAdminController
{
    private $weekMenuDAL;
    private $weekMenues;

    public function __construct($masterView, $loginView, $loginDAL){
        $loggedIn = $loginDAL->isUserLoggedIn();

        if($loggedIn){
            $this->weekMenuDAL = new WeekMenuDAL();

            //gets all weekmenues from database
            $this->weekMenues = $this->weekMenuDAL->getAllWeekMenues();
            $this->checkUserChoice($masterView, $loggedIn);
        }
    }

    /**
     * @param $masterView
     * @param $loggedIn checks to se if user is logged in
     * @throws \exceptions\DatabaseErrorException
     * This method checks what user wants to do an renders
     * different partial views accordingly
     */
    public function checkUserChoice($masterView, $loggedIn){

        if($loggedIn){
            //creates new partial views
            $menuForm = new WeekMenuView();
            $listView = new WeekMenuList();
            $html = "";

            //if user wants to add new menu
            if($menuForm->showMenuForm()){
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderAddMenuForm();
            }

            //if user wants to save menu
            else if($menuForm->userWantsToSaveMenu() && $loggedIn){
                try{
                    $this->weekMenuDAL->saveWeekMenu($menuForm->getMenu());
                    $html .= $listView->showWeekMenuList($this->weekMenues);
                }
                catch(DatabaseErrorException $e){
                    $menuForm->setErrorMessage();
                }
            }

            //if user wants to delete menu
            else if($listView->userWantsToDeleteMenu()){
                $html .=$listView->showDeleteView($this->weekMenues);

                if($listView->userConfirmsDeleteMenu() && $loggedIn){
                    try{
                        $this->weekMenuDAL->deleteWeekMenu($listView->getId());
                    }
                    catch(DatabaseErrorException $e){
                       $menuForm->setErrorMessage();
                    }

                }else{
                    $listView->userWantsToCancel();
                }
            }

            //if user wants to edit menu
            else if($listView->userWantsToEditMenu()){
                $menu = $this->weekMenuDAL->getMenuById($listView->getId());
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderEditMenuForm($menu);

                if($menuForm->userWantsUpdateMenu()){
                    try{
                        $this->weekMenuDAL->updateMenu($menuForm->getMenu());
                    }
                    catch (DatabaseErrorException $e){
                        $menuForm->setErrorMessage();
                    }

                }
                else{
                    $menuForm->userWantsToCancelUpdate();
                }
            }

            //default
            else{
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderAddWeekMenuButton();
            }
            $masterView->renderTemplateHTML($html, true);
        }
    }
}