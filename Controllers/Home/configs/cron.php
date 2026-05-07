<?php

\System\Core::Cron()->add(\Controllers\Home\Cron\IndexTask::class, 'exec', 5, 3600);
