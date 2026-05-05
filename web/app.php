<?php

include_once "../core.php";

$router = new \System\Core\Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$router->start();