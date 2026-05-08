<?php

return [
    'home.test' => 'Привіт світ!',
    'cmd.commandNotFound' => 'Невідома команда `%cmd%`!',
    'cmd.undefinedMethod' => 'Невідомий метод `%method%`!',
    'cmd.differenceArguments' => 'Розбіжність кількості обов\'язкових параметрів`%method%`!',

    'cron.newTask' => 'Нова задача %task%',
    'cron.newTaskWithoutStartStamp' => 'Нова задача %task% (без стартовой мітки)',
    'cron.expiredByStopStamp' => 'Задача %task% готова (просрочена по стоп мітці)',
    'cron.expiredByTimeout' => 'Задача %task% готова (просрочена по таймауту)',

    'cron.cronTaskNotReady' => 'Задача %task% не готова, спробуйте пізніше...',
    'cron.cronTaskNotReadyByStop' => 'Задача %task% не готова (без стоп мітки), спробуйте пізніше...',

    'cron.processesLeft' => 'Залишилось %total% процесів',
    'cron.processDoneProcessesLeft' => 'Процес %cmd% завершено (залишилось %total%)',

    'cli.make.fileSavedToPath' => 'Файл `%target%` успішно збережено до `%destination%`',
];