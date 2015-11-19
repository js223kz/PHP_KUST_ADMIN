<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/StartView.php');
class MasterController
{
    private $applicationTemplateView;



    public function __construct($applicationTemplateView)
    {
        $this->applicationTemplateView = $applicationTemplateView;
        $startView = new \views\StartView();
        $loginView = new \views\LoginView();


        //$this->checkCost();
        if($applicationTemplateView->userClickedLogin()){
            $applicationTemplateView->renderTemplateHTML($loginView->renderLoginHtml());
        }
        else if($loginView->userSubmitsLoginData()) {

        }
        else{
            $applicationTemplateView->renderTemplateHTML($startView->renderStartHtml());
            if($startView->wantsToRegisterNewUser()){
                $startView->registerUser();
                var_dump($startView->getUserName());
                var_dump($startView->getPassWord());
            }
        }
    }

    public function checkCost(){
        $timeTarget = 0.05; // 50 milliseconds

        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "Appropriate Cost Found: " . $cost . "\n";
    }


}