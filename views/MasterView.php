<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-18
 * Time: 15:07
 */

namespace views;


class MasterView
{

    private static $login = 'MasterView::Login';

    public function renderTemplateHTML($partialView){
        echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
            </head>
            <body>
                <header>
                <form method="post">
                    <input type="submit" value="Login" name='.self::$login.'>
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
}