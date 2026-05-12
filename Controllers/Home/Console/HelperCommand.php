<?php

namespace Controllers\Home\Console;

use function console\text;
use function console\danger;
use function console\warning;
use function language\translate;
use function module\loadControllersOptions;

class HelperCommand
{
    protected $command;
    protected $params = [];
    protected $commands = [];

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;

        $this->commands = loadControllersOptions('commands.php');
    }

    /**
     * @param null $controller
     * @help cli.help.callHelper
     * @help cli.help.callHelper1
     * @return bool
     */
    public function exec($controller = null)
    {
        $cmd = trim(text(PHP_BINARY, 46));
        $cmd .= ' ' . trim(text(CLI_MODE, 45));

        foreach($this->commands as $command => $params){
            list($class, $method) = $params;
            if($controller && !preg_match("#\\\\{$controller}\\\\#usm", $class)){
                continue;
            }
            $paramsLine = $this->parseCommandInfo($class, $method);
            print $cmd . ' ' . trim(danger($command)) . ' ' . $paramsLine . PHP_EOL;
        }

        return true;
    }

    protected function parseCommandInfo($class, $method)
    {
        $file = str_replace('\\', '/', $class);
        $file = trim($file, '/');
        $path = ROOT . "/{$file}.php";

        if(file_exists($path)){
            $contents = file_get_contents($path);
            $contents = preg_replace("#\s+#usim", '', $contents);

            foreach(explode("/**", $contents) as $content){
                $content = "/**" . $content;

                if(preg_match("#\/\*\*(.*?)\*\/((public)?)function{$method}\(#usim", $content, $match)){
                    $lines = explode('*', $match[1]);

                    $params = [];
                    foreach($lines as $line){
                        if(preg_match("#\@para(\w+)\\$(\w+)#", $line, $match)){
                            $params["%{$match[2]}%"] = "[{$match[2]}]";
                        }
                    }

                    $translates = [];
                    foreach($lines as $line){
                        if(preg_match("#\@help(.*?)$#", $line, $match)){
                            $translates[] = translate($match[1], $params, true);
                        }
                    }

                    return trim(warning(implode(' ', array_values($params)))) . ' - ' . implode("\n     - ", $translates);
                }
            }
        }
        return '';
    }
}