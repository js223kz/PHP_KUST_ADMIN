<?php
session_start();

/*$_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    session_destroy();*/



require_once('ini.php');
require_once('Settings.php');
require_once('controllers/MasterController.php');
require_once('views/MasterView.php');


$applicationTemplateView = new \views\MasterView();
$applicationStart = new \controllers\MasterController($applicationTemplateView);