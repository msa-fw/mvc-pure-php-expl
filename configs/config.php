<?php

\System\Core::Config()->template()->write([
    'theme' => 'default',
    'renderClass' => \System\Core\Template\HTML::class,
]);

\System\Core::Config()->session()->write([
    'sessionName' => 'SSID',
    'sessionLifeTime' => 86400*365,
    'sessionDomain' => '',
    'sessionDirectory' => '../tmp/sessions',
]);