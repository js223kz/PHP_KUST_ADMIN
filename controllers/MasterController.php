<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

use views\LoginView;
use views\LogoutView;
use views\MasterView;
use views\StartView;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/LogoutView.php');
require_once('views/StartView.php');
require_once('controllers/LoginController.php');


class MasterController
{

    public function __construct()
    {
        $masterView = new MasterView();
        $startView = new StartView();
        $loginView= new LoginView();
        $logoutView= new LogoutView();

        if($masterView->userClickedLogin()){
            $masterView->renderTemplateHTML($loginView->showLoginFrom(), false);
        }
        else if($masterView->userClickedLogout()){
            $masterView->renderTemplateHTML($logoutView->showLogoutForm(), false);
        }
        //Det är när jag går från LoginController och vidare det blir knas
        else if($loginView->userSubmitsLoginData() && $loginView->getIsUserInputValidated()){
            $masterView->renderTemplateHTML($loginView->showLoginFrom(), false);
            return new LoginController($loginView, $masterView);
        }
        else{
            $masterView->renderTemplateHTML($startView->showStartView(), false);
        }


    }

/*public function checkCost(){
        //$this->checkCost();
        $timeTarget = 0.05; // 50 milliseconds

        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "Appropriate Cost Found: " . $cost . "\n";
    }*/


}