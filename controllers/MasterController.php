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
use views\LoginView;
use views\StartView;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/StartView.php');
require_once('models/User.php');
require_once('models/LoginDAL.php');

class MasterController
{
    private $masterView;
    private $isUserLoggedIn = false;

    public function __construct($masterView)
    {
        $this->masterView = $masterView;
        $startView = new StartView();
        $loginView = new LoginView();


        if($this->masterView->userClickedLogin() || $this->isUserLoggedIn == false){
            $this->masterView->renderTemplateHTML($loginView->renderHtml($this->isUserLoggedIn));
            if($loginView->userSubmitsLoginData()){
                $user = new LoginDAL();
                $login = $user->tryLogin(new User($loginView->getUserName(), $loginView->getPassword()));
                var_dump($login);
            }
        }
        else{
            $this->masterView->renderTemplateHTML($startView->showStartView());
        }

    }

    public function checkCost(){
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
    }


}