<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

require_once('views/MasterView.php');
class MasterController
{
    private $applicationTemplateView;


    public function __construct($applicationTemplateView)
    {
        $this->applicationTemplateView = $applicationTemplateView;
        $applicationTemplateView->renderTemplateHTML();

        if($applicationTemplateView->userWantsToLogin()){
            var_dump("Login");
        }
    }

}