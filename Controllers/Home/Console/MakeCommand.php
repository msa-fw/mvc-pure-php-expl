<?php

namespace Controllers\Home\Console;

use function console\text;
use function console\success;
use function language\translate;
use function filesystem\scan_callback;

class MakeCommand
{
    protected $command;
    protected $params = [];

    protected $target = ROOT . "/Controllers/Home/Console/tpl/controller";
    protected $destination = ROOT . "/Controllers";

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function controller($controller)
    {
        scan_callback($this->target, function($directory, $file, $isDirectory)use($controller){
            if(!$isDirectory){
                $this->commonSaveFile($directory, $file, $controller);
            }
        });
        return true;
    }

    public function action($controller, $action)
    {
        $this->commonSaveFile($this->target . "/Actions", "__ACTION__Action.php", $controller, $action);
        return true;
    }

    public function model($controller, $model)
    {
        $this->commonSaveFile($this->target . "/Models", "__ACTION__Model.php", $controller, $model);
        return true;
    }

    public function command($controller, $command)
    {
        $this->commonSaveFile($this->target . "/Console", "__ACTION__Command.php", $controller, $command);
        return true;
    }

    public function cron($controller, $cron)
    {
        $this->commonSaveFile($this->target . "/Cron", "__ACTION__Task.php", $controller, $cron);
        return true;
    }

    public function event($controller, $event)
    {
        $this->commonSaveFile($this->target . "/Events", "__ACTION__Event.php", $controller, $event);
        return true;
    }

    public function table($table)
    {
        return $this->commonSaveMigrationFile($table, 'create');
    }

    public function alter($table, $suffix = null)
    {
        return $this->commonSaveMigrationFile($table, 'alter', $suffix);
    }

    protected function commonSaveMigrationFile($table, $prefix, $suffix = null)
    {
        $suffix = $suffix ? "_{$suffix}_" : "_";

        $name = "{$prefix}_{$table}{$suffix}" . time();
        $destinationDirectory = ROOT . "/temp/migration";

        if(!is_dir($destinationDirectory)){
            mkdir($destinationDirectory, 0777, true);
        }

        $target = ROOT . "/Controllers/Home/Console/tpl/migration/{$prefix}.php";
        $destination = "{$destinationDirectory}/" . date('Ymd_His') . "_{$name}.php";

        if(!file_exists($destination)){
            $content = file_get_contents($target);
            $content = str_replace(['__name__', '__table__'], [$name, $table], $content);

            file_put_contents($destination, $content);

            print translate('cli.make.fileSavedToPath', [
                    '%target%' => trim(text($target, 46)),
                    '%destination%' => trim(success($destination)),
                ]) . PHP_EOL;
        }

        return true;
    }

    protected function commonSaveFile($directory, $file, $controller, $action = '')
    {
        $action = $action ?: $controller;

        $target = "{$directory}/{$file}";
        $destination = str_replace($this->target, "{$this->destination}/{$controller}", $target);
        $destination = str_replace(['__CONTROLLER__', '__ACTION__'], [$controller, $action], $destination);

        $content = file_get_contents($target);
        $content = str_replace(['__CONTROLLER__', '__ACTION__'], [$controller, $action], $content);

        $destinationDirectory = dirname($destination);
        if(!is_dir($destinationDirectory)){
            mkdir($destinationDirectory, 0777, true);
        }

        if(file_put_contents($destination, $content)){
            print translate('cli.make.fileSavedToPath', [
                    '%target%' => trim(text($target, 46)),
                    '%destination%' => trim(success($destination)),
                ]) . PHP_EOL;
            return true;
        }
        return false;
    }
}