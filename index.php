<?php
require_once('ini.php');
require_once('Settings.php');
require_once('controllers/MasterController.php');
require_once('views/MasterView.php');


$applicationTemplateView = new \views\MasterView();
$applicationStart = new \controllers\MasterController($applicationTemplateView);