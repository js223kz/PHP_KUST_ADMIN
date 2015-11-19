<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:08
 */

namespace views;


class StartView
{
    private static $userName = 'StartView::Username';
    private static $passWord = 'StartView::Password';
    private static $submitLogin = 'StartView::Submitlogin';
    private $hashedPassword;


    public function renderStartHtml(){

    return '
        <form method="post" action="">
            <fieldset>
                <legend>Registrera</legend>
                <p></p>
                <input type="text" id="' . self::$userName . '"name="' . self::$userName . '"/>
                <input type="text" id="' . self::$passWord . '"name="' . self::$passWord . '"/>
                <input type="submit" id="' . self::$submitLogin . '" name=' . self::$submitLogin . ' value="Login"/>
			</fieldset>
		</form>
		';
    }

    public function wantsToRegisterNewUser(){
        if(isset($_POST[self::$submitLogin])){
            return true;
        }
        return false;
    }
    public function registerUser(){
        if(isset($_POST[self::$userName]) && isset($_POST[self::$passWord])){
            $this->hashedPassword = $this->hashPassword($_POST[self::$passWord]);
        }
    }

    public function getUserName()
    {
        return $_POST[self::$userName];
    }

    public function getPassWord()
    {
        return $this->hashedPassword;
    }

    private function hashPassword($password)
    {
        $options = [
            'cost' => 9,
        ];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        return $password;
    }
}