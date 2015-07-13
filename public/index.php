<?php

define ('PROJECT_ROOT', dirname(__FILE__));
define('APPLICATION_PATH', PROJECT_ROOT . '/../application');
define('LIBRARY_PATH', PROJECT_ROOT . '/../library');
define('CACHE_PATH', PROJECT_ROOT . '/../cache');

//application autoloader
require_once APPLICATION_PATH . '/Autoloader.php';
Autoloader::register();

//twig autoloader
require_once LIBRARY_PATH . '/twig/Autoloader.php';
Twig_Autoloader::register();

//get controller and action from url
$aPath = explode('/', $_GET['path']);
$sController = isset($aPath[0]) ? ucfirst(strtolower($aPath[0])) : 'Error';
$sAction = isset($aPath[1]) ? strtolower($aPath[1]) : 'index';

$oController = new $sController(strtolower($sController) . '/' . strtolower($sAction) . '.html');
$oController->$sAction();