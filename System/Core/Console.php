<?php

namespace System\Core;

use function language\translate;
use ReflectionMethod;
use function console\danger;
use function console\warning;
use function module\loadControllersOptions;

class Console
{
    protected $requestCommand;

    protected $routes = [];

    public function __construct($requestCommand)
    {
        $this->requestCommand = $requestCommand;
        $this->routes = loadControllersOptions('commands.php');
    }

    public function start()
    {
        foreach($this->routes as $command => $action){
            list($class, $method) = $action;

            $pattern = $this->command2pattern($command);
            if(preg_match($pattern, $this->requestCommand, $match) && $this->runCommand($class, $method, array_slice($match, 1))){
                return true;
            }
        }
        print danger(translate('cmd.commandNotFound', ['%cmd%' => $this->requestCommand], true));
        return false;
    }

    protected function runCommand($className, $method, array $arguments = [])
    {
        if(!method_exists($className, $method)){
            print warning(translate('cmd.undefinedMethod', ['%method%' => "{$className}::{$method}()"], true));
            return true;
        }

        if(count($arguments) < $this->getRequiredParams($className, $method)){
            print warning(translate('cmd.differenceArguments', ['%method%' => "{$className}::{$method}()"], true));
            return true;
        }

        $object = new $className();
        return call_user_func_array([$object, $method], $arguments);
    }

    protected function getRequiredParams($class, $method)
    {
        $reflection = new ReflectionMethod($class, $method);
        return $reflection->getNumberOfRequiredParameters();
    }

    protected function command2pattern($command)
    {
        return preg_replace_callback_array(array(
            "#\{\p{L}+\}#usim" => function($match){ return '(\w+)'; },
            "#\[\p{L}+\]#usim" => function($match){ return '(\d+)'; },
        ), "#^$command$#usim");
    }
}