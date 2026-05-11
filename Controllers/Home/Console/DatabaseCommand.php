<?php

namespace Controllers\Home\Console;

use Exception;
use System\Core;
use ReflectionClass;
use ReflectionMethod;

use function console\text;
use function console\danger;
use function console\success;
use function console\warning;
use function language\translate;

class DatabaseCommand
{
    protected static $magicMethods = [
        '__construct',
        '__destruct',
        '__call',
        '__callStatic',
        '__get',
        '__set',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__serialize',
        '__unserialize',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo'
    ];

    protected $command;
    protected $params = [];
    protected $connect;

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;

        $this->connect = Core::Database()->connection();
    }

    public function migrate($forced = false)
    {
        $target = ROOT . "/temp/migration";
        $temp = ROOT . "/../tmp/migration";

        if(!is_dir($temp)){
            mkdir($temp, 0777, true);
        }

        $files = glob("{$target}/*.php");

        usort($files, function($v1, $v2){
            preg_match("#\_(\d+)\.php#usim", $v1, $m1);
            preg_match("#\_(\d+)\.php#usim", $v2, $m2);

            if($m1[1] == $m2[1]){
                return 0;
            }
            return $m1[1] < $m2[1] ? -1 : 1;
        });

        foreach($files as $file){
            $filename = pathinfo($file, PATHINFO_FILENAME);

            if(!$forced && file_exists("{$temp}/{$filename}")){
                print translate('cli.migration.migrationFileNotExecuted', [
                        '%target%' => trim(text($file, 46)),
                    ]) . PHP_EOL;

                continue;
            }

            $content = file_get_contents($file);
            if(preg_match("#\nclass\s+(.*?)\{#usim", $content, $match)){
                $className = trim($match[1]);

                include_once $file;

                $reflection = new ReflectionClass($className);
                if($publicMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC)){
                    $classObject = new $className();

                    foreach($publicMethods as $method){
                        if(in_array($method->name, self::$magicMethods)){ continue; }

                        print translate('cli.migration.migrationMethodExecute', [
                                '%method%' => trim(success("{$className}::{$method->name}()")),
                                '%target%' => trim(text($filename, 46)),
                            ]) . PHP_EOL;

                        try{
                            call_user_func_array([$classObject, $method->name], []);
                        }catch(Exception $exception){
                            print danger($exception->getMessage());
                            print danger("{$className}::{$method->name}()");
                            print warning($file);
                            exit;
                        }
                    }

                    file_put_contents("{$temp}/{$filename}", time());
                }
            }
        }

        return true;
    }
}