<?php

include_once __DIR__ . "/../core.php";

\System\Core::Events()->initialize();

\System\Core::Config()->initialize();
\System\Core::Session()->initialize();

$router = new \System\Core\Router();
$router->start();

$template = new \System\Core\Template();
print $template->render();
