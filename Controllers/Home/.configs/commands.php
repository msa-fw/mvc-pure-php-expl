<?php

return [
    'cron:run' => [\Controllers\Home\Console\CronCommand::class, 'exec'],
    'server:run' => [\Controllers\Home\Console\ServerCommand::class, 'exec'],
    'test:dialog' => [\Controllers\Home\Console\DialogTestCommand::class, 'exec'],
];