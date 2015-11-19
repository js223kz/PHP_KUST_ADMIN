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

    public function renderLoginHTML(){
        return '
        <form method="post" action="">
            <fieldset>
                <legend>Logga in</legend>
                <input type="text" id="' . self::$userName . '"name="' . self::$userName . '"/>
                <input type="text" id="' . self::$passWord . '"name="' . self::$passWord . '"/>
                <input type="submit" id="' . self::$submitLogin . '" name=' . self::$submitLogin . ' value="Login"/>
			</fieldset>
		</form>
		';
    }

    public function userSubmitsLoginData(){
        if(isset($_POST[self::$submitLogin])){
            return true;
        }
        return false;
    }


}