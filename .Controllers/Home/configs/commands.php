<?php

return [
    'help' => [\Controllers\Home\Console\HelperCommand::class, 'exec'],

    'cron:run' => [\Controllers\Home\Console\CronCommand::class, 'exec'],
    'server:run' => [\Controllers\Home\Console\ServerCommand::class, 'exec'],

    'make:controller' => [\Controllers\Home\Console\MakeCommand::class, 'controller'],
    'make:action' => [\Controllers\Home\Console\MakeCommand::class, 'action'],
    'make:command' => [\Controllers\Home\Console\MakeCommand::class, 'command'],
    'make:cron' => [\Controllers\Home\Console\MakeCommand::class, 'cron'],
    'make:event' => [\Controllers\Home\Console\MakeCommand::class, 'event'],
    'make:model' => [\Controllers\Home\Console\MakeCommand::class, 'model'],
    'make:widget' => [\Controllers\Home\Console\MakeCommand::class, 'widget'],

    'make:table' => [\Controllers\Home\Console\MakeCommand::class, 'table'],
    'make:alter' => [\Controllers\Home\Console\MakeCommand::class, 'alter'],

    'db:migrate' => [\Controllers\Home\Console\DatabaseCommand::class, 'migrate'],
];