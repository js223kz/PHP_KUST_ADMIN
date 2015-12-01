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
    public function showStartView(){

        $ret =
            "<div class='startbodycontainer'>
                <h1 class='startbodytext'>Johannas CMS</h1>
            </div>";
        return $ret;
    }
}