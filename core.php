<?php

define('DEBUG_START_TIME', microtime(true));
define('DEBUG_START_MEMORY', memory_get_usage());

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

define('ROOT', __DIR__);
define('WEB', ROOT . "/web");

ini_set('memory_limit', '128M');

date_default_timezone_set('Europe/London'); // +00:00 default.

include_once ROOT . "/System/Helpers/functions.php";

if(file_exists(ROOT . '/vendor/autoload.php')){
    require_once ROOT . '/vendor/autoload.php';
}

spl_autoload_register('classesAutoloader');

