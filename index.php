<?php
session_start();

require_once('Settings.php');
require_once('controllers/MasterController.php');

$applicationStart = new \controllers\MasterController();