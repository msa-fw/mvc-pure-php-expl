<?php

return [
    'home:test' => [\Controllers\Home\Console\IndexCommand::class, 'exec'],
    'home:test {first}:{second}' => [\Controllers\Home\Console\IndexCommand::class, 'exec'],

    'cron:run' => [\Controllers\Home\Console\CronCommand::class, 'run'],                        // run common list
    'cron:run {task}' => [\Controllers\Home\Console\CronCommand::class, 'runCronTask'],         // run task from common list
    'cron:shell {task}' => [\Controllers\Home\Console\CronCommand::class, 'executeCronTask'],   // run in silent-mode (skip errors)
];