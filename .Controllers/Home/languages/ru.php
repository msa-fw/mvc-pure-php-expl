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

    'cron.processesLeft' => 'Осталось %total% процессов',
    'cron.processDoneProcessesLeft' => 'Процесс %cmd% завершен (осталось %total%)',

    'cli.debugInfo' => 'Время: %time%с Память: %memory%Кб',

    'cli.make.fileSavedToPath' => 'Файл `%target%` успешно сохранен в `%destination%`',
    'cli.make.fileAlreadyExist' => 'Файл уже существует в `%destination%`',

    'cli.migration.migrationFileExecuted' => 'Файл %target% успешно выполнен!',
    'cli.migration.migrationFileNotExecuted' => 'Файл %target% уже выполнен!',
    'cli.migration.migrationMethodExecute' => 'Вызов метода %method% с файла %target%',

    'cli.help.callHelper' => "Вызвать справку по консольным командам",
    'cli.help.callHelper1' => "Используйте ключ %controller% если нужна справка по конкретному контроллеру",

    'cli.help.runDeveloperServer' => "Запустить локальный PHP-сервер",
    'cli.help.runDeveloperServer1' => "Используйте ключ %host_port% для запуска сервера на произвольном хосте (формат [host:port])",

    'cli.help.cronExecCommand' => "Запустить менеджер CRON для всех задач",
    'cli.help.cronExecCommand1' => "Используйте ключ %key% и параметр [--single] для запуска конкретной CRON-задачи",
    'cli.help.cronExecCommand2' => "Используйте ключ %key% и параметры [--single] [--silent] для запуска конкретной CRON-задачи в \"тихом\" режиме (подавление ошибок)",

    'cli.help.makeCommandController' => "Создать набор файлов нового контроллера",
    'cli.help.makeCommandController1' => "Используйте ключ %controller% для объявления названия контроллера",
    'cli.help.makeCommandAction' => "Создать новый класс экшина",
    'cli.help.makeCommandAction1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %action% для объявления имя класса экшина",
    'cli.help.makeCommandModel' => "Создать новый класс модели",
    'cli.help.makeCommandModel1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %model% для объявления имя класса модели",
    'cli.help.makeCommandCli' => "Создать новый класс консольной команды",
    'cli.help.makeCommandCli1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %command% для объявления имя класса команды",
    'cli.help.makeCommandCron' => "Создать новый класс CRON задачи",
    'cli.help.makeCommandCron1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %cron% для объявления имя класса CRON задачи",
    'cli.help.makeCommandEvent' => "Создать новый класс события",
    'cli.help.makeCommandEvent1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %event% для объявления имя класса события",
    'cli.help.makeCommandWidget' => "Создать новый класс виджета",
    'cli.help.makeCommandWidget1' => "Используйте ключ %controller% для объявления названия контроллера и ключ %widget% для объявления имя класса виджета",

    'cli.help.makeMigrationTable' => "Создать файл миграций для новой таблицы",
    'cli.help.makeMigrationTable1' => "Используйте ключ %table% для объявления имени таблицы",
    'cli.help.makeMigrationAlter' => "Создать файл миграций для апгрейда существующей таблицы",
    'cli.help.makeMigrationAlter1' => "Используйте ключ %table% для объявления имени таблицы, и ключ %suffix% (не обязательно)",

    'cli.help.databaseMigrateCommand' => "Выполнить миграцию базы данных",
    'cli.help.databaseMigrateCommand1' => "Используйте ключ %forced% если нужно полностью отбросить предыдущие миграции (ребилд БД)",
];