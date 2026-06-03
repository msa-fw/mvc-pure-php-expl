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

    'cli.debugInfo' => 'Time: %time%s Memory: %memory%Kb',

    'cli.make.fileSavedToPath' => 'File `%target%` saved to `%destination%`',
    'cli.make.fileAlreadyExist' => 'File already exist in `%destination%`',

    'cli.migration.migrationFileExecuted' => 'File %target% executed successfull!',
    'cli.migration.migrationFileNotExecuted' => 'File %target% already executed!',
    'cli.migration.migrationMethodExecute' => 'Call method %method% from %target%',

    'cli.help.callHelper' => "Call helper for console commands",
    'cli.help.callHelper1' => "Use key %controller% if do you need help by concrete controller",

    'cli.help.runDeveloperServer' => "Run developer server",
    'cli.help.runDeveloperServer1' => "Use param %host_port% for running server by custom host (use [host:port] format)",

    'cli.help.cronExecCommand' => "Run CRON-manager for all defined CRON-tasks",
    'cli.help.cronExecCommand1' => "Use param %key% [--single] for running one CRON-task by unique key",
    'cli.help.cronExecCommand2' => "Use params %key% [--single] [--silent] for running one CRON-task by unique key in silent mode (inhibit PHP errors)",

    'cli.help.makeCommandController' => "Create new controller files",
    'cli.help.makeCommandController1' => "Use key %controller% for define controller name",
    'cli.help.makeCommandAction' => "Create new action class",
    'cli.help.makeCommandAction1' => "Use key %controller% for define controller name and %action% for define Action class name",
    'cli.help.makeCommandModel' => "Create new model class",
    'cli.help.makeCommandModel1' => "Use key %controller% for define controller name and %model% for define Model class name",
    'cli.help.makeCommandCli' => "Create new console command class",
    'cli.help.makeCommandCli1' => "Use key %controller% for define controller name and %command% for define Command class name",
    'cli.help.makeCommandCron' => "Create new CRON task class",
    'cli.help.makeCommandCron1' => "Use key %controller% for define controller name and %cron% for define Cron class name",
    'cli.help.makeCommandEvent' => "Create new event class",
    'cli.help.makeCommandEvent1' => "Use key %controller% for define controller name and %event% for define Event class name",
    'cli.help.makeCommandWidget' => "Create new widget class",
    'cli.help.makeCommandWidget1' => "Use key %controller% for define controller name and %widget% for define Widget class name",

    'cli.help.makeMigrationTable' => "Create migration file for new table",
    'cli.help.makeMigrationTable1' => "Use key %table% for define table name",
    'cli.help.makeMigrationAlter' => "Create migration file for altering existing table",
    'cli.help.makeMigrationAlter1' => "Use key %table% for define table name, and key %suffix% (not required)",

    'cli.help.databaseMigrateCommand' => "Run database migration",
    'cli.help.databaseMigrateCommand1' => "Use key %forced% if do you need reset all previous migrations (DB rebuild)",
];