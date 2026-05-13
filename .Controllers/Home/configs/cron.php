<?php

\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 5, 3600, 'exec');
\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 60, 3600, 'exec1');
\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 120, 3600, 'exec2');
