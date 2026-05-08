<?php

return [
    'cron:run' => [\Controllers\Home\Console\CronCommand::class, 'exec'],
    'server:run' => [\Controllers\Home\Console\ServerCommand::class, 'exec'],
    'test:dialog' => [\Controllers\Home\Console\DialogTestCommand::class, 'exec'],

    'make:action' => [\Controllers\Home\Console\MakeCommand::class, 'action'],
    'make:command' => [\Controllers\Home\Console\MakeCommand::class, 'command'],
    'make:controller' => [\Controllers\Home\Console\MakeCommand::class, 'controller'],
    'make:cron' => [\Controllers\Home\Console\MakeCommand::class, 'cron'],
    'make:event' => [\Controllers\Home\Console\MakeCommand::class, 'event'],
    'make:model' => [\Controllers\Home\Console\MakeCommand::class, 'model'],
];