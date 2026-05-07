<?php

\System\Core::Config()->general()->write([
    'language' => 'en',
]);

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

\System\Core::Config()->database('default')->write([
    'locale' => 'en_US',
    'charset' => 'utf8mb4',
    'collate' => 'utf8mb4_unicode_520_ci',
    'engine' => 'MyISAM',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '123',
    'base' => 'test_db',
    'port' => '3306',
    'socket' => null,
    'databaseMode' => [
        'STRICT_TRANS_TABLES',
        'NO_ZERO_IN_DATE',
        'NO_ZERO_DATE',
        'ERROR_FOR_DIVISION_BY_ZERO',
        'NO_ENGINE_SUBSTITUTION',
    ],
]);