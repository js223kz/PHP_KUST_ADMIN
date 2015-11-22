<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

use models\LoginDAL;
use models\User;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/StartView.php');
require_once('commons/DatabaseConnection.php');
require_once('models/User.php');
require_once('models/LoginDAL.php');

class MasterController
{
    private $applicationTemplateView;
    private $isUserLoggedIn = false;



    public function __construct($applicationTemplateView)
    {
        $this->applicationTemplateView = $applicationTemplateView;

        $startView = new \views\StartView();
        $loginView = new \views\LoginView();

        //$this->checkCost();
        if($applicationTemplateView->userClickedLogin() || $this->isUserLoggedIn == false){
            $applicationTemplateView->renderTemplateHTML($loginView->renderHtml($this->isUserLoggedIn));
            if($loginView->userSubmitsLoginData()){
                $user = new LoginDAL();
                $user->tryLogin(new User($loginView->getUserName(), $loginView->getPassword()));
            }
        }
        else{
            $this->applicationTemplateView->renderTemplateHTML($startView->renderHtml());
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