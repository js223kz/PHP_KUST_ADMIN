<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

use models\LoginDAL;
use views\LoginView;
use views\LogoutView;
use views\MasterView;
use views\StartView;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/LogoutView.php');
require_once('views/StartView.php');
require_once('controllers/LoginController.php');
require_once('models/LoginDAL.php');
require_once('kust/controllers/KustAdminController.php');


class MasterController
{


    public function __construct()
    {
        $masterView = new MasterView();
        $startView = new StartView();
        $loginView= new LoginView();
        $logoutView= new LogoutView();
        $loginDAL = new LoginDAL();

        $isInputValidated = $loginView->getIsUserInputValidated();

        if(!$loginDAL->isUserLoggedIn()){
            if($masterView->userClickedLogin() || $loginView->userSubmitsLoginData() && !$isInputValidated){
                $masterView->renderTemplateHTML($loginView->showLoginFrom(), false);
            }
            else if($loginView->userSubmitsLoginData() && $isInputValidated){
                return new LoginController($loginView, $masterView);
            }
            else if($masterView->userClickedLogout()){
                $masterView->renderTemplateHTML($logoutView->showLogoutForm(), false);

            }else{
                $masterView->renderTemplateHTML($startView->showStartView(), false);
            }
        }else{
            return new KustAdminController($masterView, $loginDAL);
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