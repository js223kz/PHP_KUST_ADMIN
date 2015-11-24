<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-23
 * Time: 11:19
 */

namespace controllers;
use views\KustAdminView;

require_once('models/LoginDAL.php');
require_once('kust/views/KustAdminView.php');
require_once('views/MasterView.php');

class KustAdminController
{

    private $kustStartView;
    public function __construct($masterView, $loginDAL){

        if($loginDAL->isUserLoggedIn() && $loginDAL->getRemoteAddress() == $_SERVER['REMOTE_ADDR']){
            $this->kustStartView = new KustAdminView();
            $masterView->renderTemplateHTML($this->kustStartView->renderView(), true);
        }else{

        }
    }

}