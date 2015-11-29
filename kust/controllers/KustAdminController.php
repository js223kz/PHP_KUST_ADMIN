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
require_once('views/LoginView.php');

class KustAdminController
{

    private $kustStartView;
    public function __construct($masterView, $loginView, $loginDAL){
        if($loginDAL->isUserLoggedIn()){
            $kustStartView = new KustAdminView();
            $masterView->renderTemplateHTML($kustStartView->renderAdminView(), true);
        }else{
            $loginView->redirect();
        }
    }

}