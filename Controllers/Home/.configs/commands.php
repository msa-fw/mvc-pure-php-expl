<?php

return [
    'cron:run' => [\Controllers\Home\Console\CronCommand::class, 'run'],                        // run common list
    'cron:run {task}' => [\Controllers\Home\Console\CronCommand::class, 'runCronTask'],         // run task from common list
    'cron:exec {task}' => [\Controllers\Home\Console\CronCommand::class, 'executeCronTask'],    // run in silent-mode (skip errors)
];