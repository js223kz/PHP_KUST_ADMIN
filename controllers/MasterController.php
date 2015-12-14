<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

use models\LoginDAL;
use views\KustAdminView;
use views\LoginView;
use views\LogoutView;
use views\MasterView;
use views\StartView;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/StartView.php');
require_once('controllers/LoginController.php');
require_once('models/LoginDAL.php');
require_once('kust/controllers/KustAdminController.php');


//Controller that handles navigation according
//to user loginstatus
class MasterController
{
    public function __construct()
    {
        $this->checkUserStatus();
    }

    private function checkUserStatus(){

        $loginDAL = new LoginDAL();
        $loginView= new LoginView($loginDAL);
        $masterView = new MasterView($loginDAL, $loginView);
        $isInputValidated = $loginView->getIsInputValidated();

        if(!$loginDAL->isUserLoggedIn()){

            //user wants to start login process or enters input data that is not valid
            if($masterView->userClickedLogin() || $loginView->userSubmitsLoginData()
                && !$isInputValidated){

                $masterView->renderTemplateHTML($loginView->showLoginFrom());
            }
            //user has entered valid data, use LoginController and try authenticate user
            else if($loginView->userSubmitsLoginData() && $isInputValidated){
                $loginController = new LoginController();
                $loggedIn = $loginController->checkUserCredentials($loginView, $loginDAL);

                if($loggedIn){
                    //if user is found in database
                    return new KustAdminController($masterView, $loginDAL);
                }else{
                    $masterView->renderTemplateHTML($loginView->showLoginFrom());
                }
            }
            else{
                //if none of the above keep going back to StartView
                $startView = new StartView();
                $masterView->renderTemplateHTML($startView->showHomeView($loginDAL->isUserLoggedIn()));
            }
        }
        else if($masterView->userClickedLogout()) {
            $masterView->logout();
        }
        else{
            //If user is authenticated and logged in
            return new KustAdminController($masterView, $loginDAL);
        }
    }
}




//used this function to check ok cost
//when key stretching
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
