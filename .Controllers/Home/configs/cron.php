<?php

\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 5, 3600, 'exec');        // example
\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 60, 3600, 'exec1');      // example
\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 120, 3600, 'exec2');     // example

\System\Core::Cron()->add(\Controllers\Home\Cron\UpdateCronTask::class, 'exec', 86400, 3600, 'updater:run');    // script updater
