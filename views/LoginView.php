<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:07
 */

namespace views;

class LoginView
{
    private static $userName = 'LoginView::Username';
    private static $passWord = 'LoginView::Password';
    private static $submitLogin = 'LoginView::Submitlogin';
    private $responseMessage;
    private $isUserInputValidated = false;

    //purely for user friendly reason
    //keeping entered username visible
    //in input field through POST
    private $username;

    public function __construct()
    {
        $this->setReponseMessage();
    }

    //renders a partial view when user
    //wants to login. Header, login, logout
    //is rendered in MasterView
    public function showLoginFrom(){
        return '
            <form class="loginform" method="post" action="">
                <fieldset class="loginfieldset">
                    <legend>Logga in</legend>
                    <p>'.$this->getMessage().'</p>
                    <input type="text" id="' . self::$userName . '"name="' . self::$userName . '" value="'.$this->getUserName().'"/>
                    <input type="text" id="' . self::$passWord . '"name="' . self::$passWord . '"/>
                    <input class="submitlogin" type="submit" id="' . self::$submitLogin . '" name=' . self::$submitLogin . ' value="Login"/>
                </fieldset>
            </form>
		';
    }

    public function userSubmitsLoginData(){
        return isset($_POST[self::$submitLogin]);
    }
    public function getMessage(){
        return $this->responseMessage;
    }

    public function getUserName(){
        if(isset($_POST[self::$userName])){
            return $_POST[self::$userName];
        }
        return null;
    }
    public function getPassword(){
        if(isset($_POST[self::$passWord])){
            return $_POST[self::$passWord];
        }
        return null;
    }

    /**
     * @return bool to MasterController if
     * user input is validated
     */
    public function getIsUserInputValidated(){
        return $this->isUserInputValidated;
    }

    public function redirect(){
        header('Location: /');
    }


    /**
     * sets appropriate response message
     * according to user input
     * only allows MasterController to
     * create new User object if user input
     * is validated
     * Called from constructor
     */
    public function setReponseMessage(){

        if(isset($_POST[self::$submitLogin])){
            $userName = trim($_POST[self::$userName]);
            $passWord = trim($_POST[self::$passWord]);

            if(empty($userName) && empty($passWord))
            {
                $this->setEmptyBothMessage();
            }
            else if(empty($userName) && !empty($passWord))
            {
                $this->username = $userName;
                $this->setEmptyUsernameMessage();
            }
            else if(!empty($userName) && empty($passWord))
            {
                $this->username = $userName;
                $this->setEmptyPasswordMessage();
            }
            else if(mb_strlen($userName) != mb_strlen(strip_tags($userName)) ||
                mb_strlen($passWord) != mb_strlen(strip_tags($passWord))){
                $this->username = "Fy!";
                $this->setNotAllowedMessage();
            }
            else{
                $this->isUserInputValidated = true;
            }
        }
    }

    public function setNotValidUserMessage(){
        $this->responseMessage = "Fel användarnamn eller lösenord.";
    }
    public function setEmptyUsernameMessage(){
        $this->responseMessage = "Användarnamn saknas.";
    }
    public function setEmptyPasswordMessage(){
        $this->responseMessage = "Lösenord saknas.";
    }
    public function setEmptyBothMessage(){
        $this->responseMessage = 'Användarnamn och lösenord saknas.';
    }
    public function setNotAllowedMessage(){
        $this->responseMessage = "Användarnamn/lösenord innehåller otillåtna tecken.";
    }
    public function setDatabaseErrorMessage(){
        $this->responseMessage = "Något gick fel i kontakten med servern. Försök igen.";
    }
}