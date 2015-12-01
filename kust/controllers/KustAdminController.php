<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-23
 * Time: 11:19
 */

namespace controllers;
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
            $this->weekMenues = $this->weekMenuDAL->getAllWeekMenues();
            $this->checkUserChoice($masterView, $loggedIn);
        }
    }

    public function checkUserChoice($masterView, $loggedIn){
        if($loggedIn){

            $menuForm = new WeekMenuView();
            $listView = new WeekMenuList();
            $html = "";

            if($menuForm->showMenuForm()){
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderAddMenuForm();
            }
            else if($menuForm->userWantsToSaveMenu()){
                $this->weekMenuDAL->saveWeekMenu($menuForm->getMenu());
                $html .= $listView->showWeekMenuList($this->weekMenues);

            }
            else if($listView->userWantsToDeleteMenu()){
                $html .=$listView->showDeleteView($this->weekMenues);

                if($listView->userConfirmsDeleteMenu()){
                    $this->weekMenuDAL->deleteWeekMenu($listView->getId());
                }else{
                    $listView->userWantsToCancel();
                }
            }
            else if($listView->userWantsToEditMenu()){
                $menu = $this->weekMenuDAL->getMenuById($listView->getId());
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderEditMenuForm($menu);

                if($menuForm->userWantsUpdateMenu()){
                    $this->weekMenuDAL->updateMenu($menuForm->getMenu());
                }
                else{
                    $menuForm->userWantsToCancelUpdate();
                }
            }
            else{
                $html .= $listView->showWeekMenuList($this->weekMenues);
                $html .= $menuForm->renderAddWeekMenuButton();
            }
            $masterView->renderTemplateHTML($html, true);
        }
    }
}