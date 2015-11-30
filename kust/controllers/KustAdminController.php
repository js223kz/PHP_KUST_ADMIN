<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-23
 * Time: 11:19
 */

namespace controllers;
use models\WeekMenuDAL;
use views\WeekMenuView;
use views\KustAdminView;

require_once('models/LoginDAL.php');
require_once('kust/models/WeekMenuDAL.php');
require_once('kust/views/KustAdminView.php');
require_once('kust/views/WeekMenuView.php');
require_once('views/MasterView.php');
require_once('views/LoginView.php');

class KustAdminController
{
    public function __construct($masterView, $loginView, $loginDAL){
        if($loginDAL->isUserLoggedIn()){
            $this->renderHtml($masterView);
        }else{
            $loginView->redirect();
        }
    }

    public function renderHtml($masterView){
        $addWeekMenuPartial = new WeekMenuView();
        $kustStartView = new KustAdminView();
        $html = "";

        if($addWeekMenuPartial->showMenuForm()){
            $html .= $addWeekMenuPartial->renderAddWeekMenuForm();
        }
        else if($addWeekMenuPartial->userWantsToSaveMenu()){
            $weekMenuDAL = new WeekMenuDAL();
            $weekMenuDAL->saveWeekMenu($addWeekMenuPartial->getWeekMenuToSave());
            $html .= $addWeekMenuPartial->renderAddWeekMenuButton();
        }else{
            $html .= $addWeekMenuPartial->renderAddWeekMenuButton();
        }

        $masterView->renderTemplateHTML($html, true);
    }

}