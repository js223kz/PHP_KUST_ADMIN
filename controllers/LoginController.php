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


class LoginController
{
    public function __construct($loginView){
        $this->checkUserCredentials($loginView);
    }

    public function checkUserCredentials($loginView){
        $loginDAL = new LoginDAL();

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
    }
}