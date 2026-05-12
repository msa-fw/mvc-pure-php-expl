<?php

namespace System\Core;

use ReflectionMethod;
use System\Core;
use function console\text;
use function console\danger;
use function console\warning;
use function language\translate;
use function module\loadControllersOptions;

class Console
{
    protected $requestCommand;

    protected $commands = [];

    public function __construct($requestCommand)
    {
        $this->requestCommand = $requestCommand;
        $this->commands = loadControllersOptions('commands.php');
    }

    public function start()
    {
        foreach($this->commands as $command => $action){
            if(preg_match("#^$command$#usim", $this->requestCommand[0])){
                if($this->runCommand($command, array_slice($this->requestCommand, 1))){

                    print PHP_EOL . str_repeat('=', 50) . PHP_EOL;
                    print translate('cli.debugInfo', [
                        '%time%' => trim(text(number_format(microtime(true) - DEBUG_START_TIME, 10), 45)),
                        '%memory%' => trim(text(number_format((memory_get_usage() - DEBUG_START_MEMORY) / 1024, 2), 46)),
                    ]) . PHP_EOL;

                    return true;
                }
            }
        }
        print danger(translate('cmd.commandNotFound', ['%cmd%' => implode(' ', $this->requestCommand)], true));
        return false;
    }

    protected function runCommand($command, array $arguments = [])
    {
        list($class, $method) = $this->commands[$command];

        if(!method_exists($class, $method)){
            print warning(translate('cmd.undefinedMethod', ['%method%' => "{$class}::{$method}()"], true));
            return true;
        }

        if(count($arguments) < $this->getRequiredParams($class, $method)){
            print warning(translate('cmd.differenceArguments', ['%method%' => "{$class}::{$method}()"], true));
            return true;
        }

        Core::Events()->beforeCommandStart()->run();

        $params = $this->extractParamsFromArguments($arguments);

        $object = new $class($command, $params);
        $result = call_user_func_array([$object, $method], $arguments);

        Core::Events()->afterCommandStart()->run();

        return $result;
    }

    protected function getRequiredParams($class, $method)
    {
        $reflection = new ReflectionMethod($class, $method);
        return $reflection->getNumberOfRequiredParameters();
    }

    protected function extractParamsFromArguments(array &$arguments)
    {
        $params = [];
        foreach($arguments as $index => $argument){
            if(strpos($argument, '--') !== false){
                $argument = ltrim($argument, '-');
                $tmp = array_map('trim', explode('=', $argument));
                $params[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : true;
                unset($arguments[$index]);
            }
        }
        $arguments = array_values($arguments);
        return $params;
    }
}