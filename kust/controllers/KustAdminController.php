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
use views\DeleteView;
use views\KustListView;
use views\WeekMenuList;
use views\WeekMenuForm;

require_once('models/LoginDAL.php');
require_once('kust/models/WeekMenuDAL.php');
require_once('kust/views/WeekMenuForm.php');
require_once('kust/views/WeekMenuList.php');
require_once('kust/views/DeleteView.php');
require_once('views/MasterView.php');

class KustAdminController
{
    private $weekMenuDAL;
    private $weekMenues;

    public function __construct($masterView, $loginDAL){
        $loggedIn = $loginDAL->isUserLoggedIn();

        if($loggedIn){
            $this->weekMenuDAL = new WeekMenuDAL();

            //gets all weekmenues from database
            $this->weekMenues = $this->weekMenuDAL->getAllMenues();
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
            $menuForm = new WeekMenuForm();
            $listView = new WeekMenuList();
            $html = "";

            //if user wants to add new menu
            if($menuForm->showMenuForm()){
                $html .= $listView->showMenuList($this->weekMenues);
                $html .= $menuForm->renderAddMenuForm($this->weekMenues);
            }

            //if user wants to save menu
            else if($menuForm->userWantsToSaveMenu() && $menuForm->isTokenValid()){
                try{
                    $this->weekMenuDAL->saveMenu($menuForm->getMenu());
                    $html .= $listView->showMenuList($this->weekMenues);
                }
                catch(DatabaseErrorException $e){
                    $menuForm->setErrorMessage();
                }
            }

            //if user wants to delete menu
            else if($listView->userWantsToDeleteMenu()){
                $deleteView = new DeleteView();
                $html .=$deleteView->showDeleteView($this->weekMenues, $listView->getId());

                //if user wants to comfirms deletion of menu
                if($deleteView->userConfirmsDeleteMenu() && $deleteView->isTokenValid()){
                    try{
                        $this->weekMenuDAL->deleteMenu($listView->getId());
                    }
                    catch(DatabaseErrorException $e){
                       $menuForm->setErrorMessage();
                    }
                }
                else{
                    $deleteView->cancelDelete();
                }
            }

            //if user wants to edit menu
            else if($listView->userWantsToEditMenu()){
                $menu = $this->weekMenuDAL->getMenuById($listView->getId());
                $html .= $listView->showMenuList($this->weekMenues);
                $html .= $menuForm->renderEditMenuForm($this->weekMenues, $menu);

                if($menuForm->userWantsUpdateMenu() && $menuForm->isTokenValid()){
                    try{
                        $this->weekMenuDAL->updateMenu($menuForm->getMenu());
                    }
                    catch (DatabaseErrorException $e){
                        $menuForm->setErrorMessage();
                    }
                }
                else{
                    $menuForm->cancelUpdate();
                }
            }

            //default
            else{
                $html .= $menuForm->renderAddWeekMenuButton();
                $html .= $listView->showMenuList($this->weekMenues);

            }
            $masterView->renderTemplateHTML($html, true);
        }
    }
}