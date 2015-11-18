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

    public function renderTemplateHTML($partialView){
        echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
            </head>
            <body>
                <header><button value="Login" type="submit"></button></header>
                <div class="container">

               </div>
             </body>
          </html>
    ';





    }

}