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

        if($loginDAL->isUserLoggedIn()){
            $this->weekMenuDAL = new WeekMenuDAL();
            $this->weekMenues = $this->weekMenuDAL->getAllWeekMenues();
            $this->renderHtml($masterView);
        }else{
            //Den här måste göras på annat sätt
            $loginView->redirect();
        }
    }

    public function renderHtml($masterView){

        $addWeekMenuPartial = new WeekMenuView();
        $listView = new WeekMenuList();
        $html = "";

        if($addWeekMenuPartial->showMenuForm()){
            $html .= $listView->showWeekMenuList($this->weekMenues);
            $html .= $addWeekMenuPartial->renderAddMenuForm();
        }
        else if($addWeekMenuPartial->userWantsToSaveMenu()){
            $this->weekMenuDAL->saveWeekMenu($addWeekMenuPartial->getMenu());
            $html .= $listView->showWeekMenuList($this->weekMenues);

        }else if($listView->userWantsToDeleteMenu()){
            $html .=$listView->showDeleteView($this->weekMenues);
            if($listView->userConfirmsDeleteMenu()){
                $this->weekMenuDAL->deleteWeekMenu($listView->getId());
            }else{
                $listView->userWantsToCancel();
            }
        }else if($listView->userWantsToEditMenu()){
            $menu = $this->weekMenuDAL->getMenuById($listView->getId());
            $html .= $listView->showWeekMenuList($this->weekMenues);
            $html .= $addWeekMenuPartial->renderEditMenuForm($menu);

            if($addWeekMenuPartial->userWantsUpdateMenu()){
                $this->weekMenuDAL->updateMenu($addWeekMenuPartial->getMenu());
            }else{
                $addWeekMenuPartial->userWantsToCancelUpdate();
            }
        }else{
            $html .= $listView->showWeekMenuList($this->weekMenues);
            $html .= $addWeekMenuPartial->renderAddWeekMenuButton();
        }

        $masterView->renderTemplateHTML($html, true);
    }

}