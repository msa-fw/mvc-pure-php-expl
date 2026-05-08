<?php

\System\Core::Config()->controller('Home')->write(['active' => true]);

\System\Core::Config()->general()->write([
    'language' => 'en',
]);

\System\Core::Config()->template()->write([
    'theme' => 'default',
    'renderClass' => \System\Core\Template\HTML::class,
    'allowedRequestMethods' => [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'PATCH',
        'OPTIONS',
        'HEAD',
        'CONNECT',
        'TRACE'
    ]
]);

\System\Core::Config()->session()->write([
    'sessionName' => 'SSID',
    'sessionLifeTime' => 86400*365,
    'sessionDomain' => '',
    'sessionDirectory' => '../tmp/sessions',
]);

\System\Core::Config()->database('default')->write([
    'driver' => '[MYSQL_DRIVER]',
    'locale' => 'en_US',
    'charset' => 'utf8mb4',
    'collate' => 'utf8mb4_unicode_520_ci',
    'engine' => 'MyISAM',
    'host' => '[MYSQL_HOST]',
    'port' => '[MYSQL_PORT]',
    'user' => '[MYSQL_USER]',
    'pass' => '[MYSQL_PASSWORD]',
    'base' => '[MYSQL_DATABASE]',
    'socket' => null,
    'databaseMode' => [
        'STRICT_TRANS_TABLES',
        'NO_ZERO_IN_DATE',
        'NO_ZERO_DATE',
        'ERROR_FOR_DIVISION_BY_ZERO',
        'NO_ENGINE_SUBSTITUTION',
    ],
]);