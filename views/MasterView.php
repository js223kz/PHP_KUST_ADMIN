<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:07
 */

namespace views;

require_once('models/LoginDAL.php');
require_once('views/LoginView.php');
require_once('views/LogoutView.php');
class MasterView
{

    private static $login = 'MasterView::Login';
    private static $logout = 'MasterView::Logout';


    public function renderTemplateHTML($partialView, $loggedIn){
        echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
            </head>
            <body>
                <header>
                <form method="post">
                     '.$this->showLoginLogout($loggedIn).'
                </form>
                </header>
                <div class="container">
                '.$partialView.'
                </div>
             </body>
          </html>
    ';
    }

    public function userClickedLogin(){
        if(isset($_POST[self::$login])){
            return true;
        }
        return false;
    }

    public function userClickedLogout(){
        if(isset($_POST[self::$logout])){
            return true;
        }
        return false;
    }

    public function showLoginLogout($loggedIn){
        $ret = '';
        if($loggedIn){
            $ret .=   '<input type="submit" value="Logout" name='.self::$logout.'>';

        }else{
            $ret .=   '<input type="submit" value="Login" name='.self::$login.'>';
        }
        return $ret;
    }
}