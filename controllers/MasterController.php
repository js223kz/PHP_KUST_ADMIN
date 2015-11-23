<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:06
 */

namespace controllers;

use exceptions\DatabaseErrorException;
use exceptions\EmptyPasswordException;
use exceptions\EmptyUsernameException;
use exceptions\NotAllowedException;
use models\LoginDAL;
use models\User;
use views\LoginView;
use views\StartView;

require_once('views/MasterView.php');
require_once('views/LoginView.php');
require_once('views/StartView.php');
require_once('models/User.php');
require_once('models/LoginDAL.php');
require_once('controllers/KustAdminController.php');


class MasterController
{
    private $masterView;

    public function __construct($masterView)
    {
        $this->masterView = $masterView;
        $loginView = new LoginView();
        $loginModel = new LoginDAL();

        if($this->masterView->userClickedLogin() || $loginView->userSubmitsLoginData() && !$loginModel->isUserLoggedIn()){
            $this->masterView->renderTemplateHTML($loginView->showLoginFrom());
            if($loginView->userSubmitsLoginData() && $loginView->getIsUserInputValidated()){

                try{
                    $user = new User($loginView->getUserName(), $loginView->getPassword());
                    $loginModel->tryLogin($user);
                }catch (EmptyUsernameException $e){
                    $loginView->setEmptyUsernameMessage();

                }catch (EmptyPasswordException $e){
                    $loginView->setEmptyPasswordMessage();

                }catch (NotAllowedException $e){
                    $loginView->setNotAllowedMessage();
                }
                catch (DatabaseErrorException $e){
                    $loginView->setDatabaseErrorMessage();
                }
            }
        }else if($loginModel->isUserLoggedIn()) {
            return new KustAdminController();
        }else {
            $startView = new StartView();
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