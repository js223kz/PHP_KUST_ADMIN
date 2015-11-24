<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-24
 * Time: 14:50
 */

namespace controllers;

use models\LoginDAL;
use models\User;

require_once('models/LoginDAL.php');
require_once('models/User.php');
require_once('views/LoginView.php');
require_once('views/MasterView.php');


class LoginController
{
    public function __construct($loginView, $loginDAL){
        $this->checkUserCredentials($loginView, $loginDAL);
    }

    public function checkUserCredentials($loginView, $loginDAL){

        try {
            $user = new User($loginView->getUserName(), $loginView->getPassword());
            $loginDAL->tryLogin($user);

        } catch (EmptyUsernameException $e) {
            $loginView->setEmptyUsernameMessage();

        } catch (EmptyPasswordException $e) {
            $loginView->setEmptyPasswordMessage();

        } catch (NotAllowedException $e) {
            $loginView->setNotAllowedMessage();

        } catch (DatabaseErrorException $e) {
            $loginView->setDatabaseErrorMessage();
        }

        $loginView->redirect();
    }
}