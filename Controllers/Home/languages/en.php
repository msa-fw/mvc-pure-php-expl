<?php

return [
    'home.test' => 'Hello world!',
    'cmd.commandNotFound' => 'Command `%cmd%` not found!',
    'cmd.undefinedMethod' => 'Undefined method `%method%`!',
    'cmd.differenceArguments' => 'Difference of required params for method `%method%`!',

    'cron.newTask' => 'New CRON task `%task%`',
    'cron.newTaskWithoutStartStamp' => 'New CRON task `%task%` (without start stamp)',
    'cron.expiredByStopStamp' => 'Task `%task%` ready (expired by stop stamp)',
    'cron.expiredByTimeout' => 'Task `%task%` ready (expired by timeout)',

    'cron.cronTaskNotReady' => 'Task `%task%` not ready, try latter...',
    'cron.cronTaskNotReadyByStop' => 'Task `%task%` not ready (by stop stamp), try latter...',

    'cron.processesLeft' => 'Processes left: %total%',
    'cron.processDoneProcessesLeft' => 'Process %cmd% completed (%total% left)',

    'cli.make.fileSavedToPath' => 'File `%target%` saved to `%destination%`',

    'cli.migration.migrationFileExecuted' => 'File %target% executed successfull!',
    'cli.migration.migrationFileNotExecuted' => 'File %target% already executed!',
    'cli.migration.migrationMethodExecute' => 'Call method %method% from %target%',
];