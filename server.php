<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$link = urldecode($_SERVER['REQUEST_URI']);
$link = parse_url($link, PHP_URL_PATH);

if($link !== '/' && file_exists(__DIR__ . "/$link")){
    return false;
}
return include_once __DIR__ . "/web/app.php";
