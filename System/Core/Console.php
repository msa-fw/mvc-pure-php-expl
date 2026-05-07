<?php

namespace System\Core;

use ReflectionMethod;
use function console\danger;
use function console\warning;

class Console
{
    protected $requestCommand;

    protected $routes = [];

    public function __construct($requestCommand)
    {
        $this->requestCommand = $requestCommand;
        $this->routes = include ROOT . "/configs/commands.php";
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
        print danger("Command `{$this->requestCommand}` not found!");
        return false;
    }

    protected function runCommand($className, $method, array $arguments = [])
    {
        if(!method_exists($className, $method)){
            print warning("Undefined method `{$className}::{$method}()`!");
            return true;
        }

        if(count($arguments) < $this->getRequiredParams($className, $method)){
            print warning("Difference of required params for method `{$className}::{$method}()`!");
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