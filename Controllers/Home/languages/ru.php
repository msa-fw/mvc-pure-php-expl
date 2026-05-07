<?php

return [
    'home.test' => 'Привет мир!',
    'cmd.commandNotFound' => 'Команда `%cmd%` не найдена!',
    'cmd.undefinedMethod' => 'Неизвесный метод `%method%`!',
    'cmd.differenceArguments' => 'Не совпадение обязательных параметров для `%method%`!',

    'cron.newTask' => 'Новая задача %task%',
    'cron.newTaskWithoutStartStamp' => 'Новая задача %task% (без стартовой метки)',
    'cron.expiredByStopStamp' => 'Задача %task% готова (истекла по стоп метке)',
    'cron.expiredByTimeout' => 'Задача %task% готова (истекла по таймауту)',

    'cron.cronTaskNotReady' => 'Задача %task% не готова, попробуйте позже...',
    'cron.cronTaskNotReadyByStop' => 'Задача %task% не готова (без стоп метки), попробуйте позже...',
];