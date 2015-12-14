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


/**
 * Class LoginController
 * @package controllers
 * checks user input against
 * database and returns user status
 */
class LoginController
{
    public function checkUserCredentials($loginView, $loginDAL){
        $loggedIn = false;
        try {
            $user = new User($loginView->getUserName(), $loginView->getPassword());
            $userAuthenticated = $loginDAL->tryLogin($user);
            if(!$userAuthenticated || $userAuthenticated == null){
                $loginView->setNotValidUserMessage();
            }else{
                $loggedIn = true;
            }

        } catch (EmptyUsernameException $e) {
            $loginView->setEmptyUsernameMessage();

        } catch (EmptyPasswordException $e) {
            $loginView->setEmptyPasswordMessage();

        } catch (NotAllowedException $e) {
            $loginView->setNotAllowedMessage();

        } catch (DatabaseErrorException $e) {
            $loginView->setDatabaseErrorMessage();
        }
        return $loggedIn;
    }
}