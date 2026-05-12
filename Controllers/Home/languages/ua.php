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

    'cli.migration.migrationFileExecuted' => 'Файл %target% успішно виконано!',
    'cli.migration.migrationFileNotExecuted' => 'Файл %target% раніше було виконано!',
    'cli.migration.migrationMethodExecute' => 'Виклик метода %method% з файлу %target%',

    'cli.help.callHelper' => "Викликати довідку по консольним командам",
    'cli.help.callHelper1' => "Використовуйте ключ %controller% якщо потрібна довідка по конкретному контролеру",

    'cli.help.runDeveloperServer' => "Запустити локальний PHP-сервер",
    'cli.help.runDeveloperServer1' => "Використовуйте ключ %host% для запуску сервера на кастомном хості (формат [host:port])",
    'cli.help.cronExecCommand' => "Запустити менеджер CRON для всіх задач",
    'cli.help.cronExecCommand1' => "Використовуйте ключ %key% і параметр [--single] для запуску конкретної CRON-задачі",
    'cli.help.cronExecCommand2' => "Використовуйте ключ %key% і параметри [--single] [--silent] для запуску конкретної CRON-задачі в \"тихому\" режимі (ігнорити помилки)",

    'cli.help.makeCommandController' => "Створити набор файлів нового контролера",
    'cli.help.makeCommandController1' => "Використовуйте ключ %controller% для оголошення назви контролера",
    'cli.help.makeCommandAction' => "Створити новий клас екшена",
    'cli.help.makeCommandAction1' => "Використовуйте ключ %controller% для оголошення назви контролера і ключ %action% для оголошення назви класа екшена",
    'cli.help.makeCommandModel' => "Створити новий клас моделі",
    'cli.help.makeCommandModel1' => "Використовуйте ключ %controller% для оголошення назви контролера і ключ %model% для оголошення назви класа моделі",
    'cli.help.makeCommandCli' => "Створити новий клас консольної команди",
    'cli.help.makeCommandCli1' => "Використовуйте ключ %controller% для оголошення назви контролера і ключ %command% для оголошення назви класа команди",
    'cli.help.makeCommandCron' => "Створити новий клас CRON задачі",
    'cli.help.makeCommandCron1' => "Використовуйте ключ %controller% для оголошення назви контролера і ключ %cron% для оголошення назви класа CRON задачі",
    'cli.help.makeCommandEvent' => "Створити новий клас події",
    'cli.help.makeCommandEvent1' => "Використовуйте ключ %controller% для оголошення назви контролера і ключ %event% для оголошення назви класа події",

    'cli.help.makeMigrationTable' => "Створити файл міграції для нової таблиці",
    'cli.help.makeMigrationTable1' => "Використовуйте ключ %table% для оголошення ім'я таблиці",
    'cli.help.makeMigrationAlter' => "Створити файл міграції для апгрейда існуючої таблиці",
    'cli.help.makeMigrationAlter1' => "Використовуйте ключ %table% для оголошення ім'я таблиці, і ключ %suffix% (не обов'язково)",

    'cli.help.databaseMigrateCommand' => "Виконати міграцію бази даних",
    'cli.help.databaseMigrateCommand1' => "Використовуйте ключ %forced% якщо потрібно повністю відкинути всі попередні міграції (ребілд БД)",
];