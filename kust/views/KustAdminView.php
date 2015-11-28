<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-24
 * Time: 13:46
 */

namespace views;


require_once('AddWeekMenuView.php');

class KustAdminView
{

    public function renderAdminView(){


        $addWeekMenuPartial = new AddWeekMenuView();
        $html = "";
        if($addWeekMenuPartial->showMenuForm() || $addWeekMenuPartial->saveMenu()){
            $html .= $addWeekMenuPartial->renderAddWeekMenuForm();
        }else {
            $html .= $addWeekMenuPartial->renderAddWeekMenuButton();
        }

        return $html;
    }
}