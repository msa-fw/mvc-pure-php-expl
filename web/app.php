<?php

include_once __DIR__ . "/../core.php";

\System\Core::Events()->initialize();

\System\Core::Config()->initialize();
\System\Core::Session()->initialize();

$router = new \System\Core\Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$router->start();

$template = new \System\Core\Template();
print $template->render();
