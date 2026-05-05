<?php

include_once "../core.php";

\System\Core::Config()->initialize();

$router = new \System\Core\Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$router->start();

$template = new \System\Core\Template();
print $template->render();

dbgd(\System\Core::Response(), \System\Core::Config());