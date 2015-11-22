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
    private $message;
    private $username;

    public function renderLoginFrom(){
        return '
        <form method="post" action="">
            <fieldset>
                <legend>Logga in</legend>
                <p>'.$this->getMessage().'</p>
                <input type="text" id="' . self::$userName . '"name="' . self::$userName . '" value="'.$this->getUserName().'"/>
                <input type="text" id="' . self::$passWord . '"name="' . self::$passWord . '"/>
                <input type="submit" id="' . self::$submitLogin . '" name=' . self::$submitLogin . ' value="Login"/>
			</fieldset>
		</form>
		';
    }

    public function renderHtml(){

        if(isset($_POST[self::$submitLogin])){
            $userName = trim($_POST[self::$userName]);
            $passWord = trim($_POST[self::$passWord]);

            if(empty($userName) && empty($passWord))
            {
                $this->setMessage('Användarnamn och lösenord saknas.');
            }
            if(empty($userName) && !empty($passWord))
            {
                $this->username = $userName;
                $this->setMessage('Användarnamn saknas.');
            }
            if(!empty($userName) && empty($passWord))
            {
                $this->username = $userName;
                $this->setMessage('Lösenord saknas.');
            }
            if(mb_strlen($userName) != mb_strlen(strip_tags($userName)) ||
                mb_strlen($passWord) != mb_strlen(strip_tags($passWord))){
                $this->username = "";
                $this->setMessage('Användarnamn/lösenord innehåller otillåtna tecken.');
            }
        }
        return $this->renderLoginFrom();

    }



    public function userSubmitsLoginData(){
        return isset($_POST[self::$submitLogin]);
    }

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getUserName(){
        if(isset($_POST[self::$userName])){
            return $_POST[self::$userName];
        }
        return null;

    }

    public function getPassword(){
        return $_POST[self::$passWord];
    }
}