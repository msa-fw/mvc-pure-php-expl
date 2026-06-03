<?php

foreach(glob(ROOT . "/System/Helpers/functions/*.php") as $file){
    include_once $file;
}

function dbg(...$_)
{
    $header = "<pre>";
    $footer = "</pre>";
    $limit = "<hr>";
    if(defined('CLI_MODE')){
        $header = $footer = str_repeat('=', 100) . PHP_EOL;
        $limit =  PHP_EOL. str_repeat('-', 100) . PHP_EOL;
    }

    print $header;
    foreach($_ as $arg){
        print_r($arg);
        print $limit;
    }
    print $footer;
}

function dbgd(...$_)
{
    dbg(...$_);
    exit();
}

function classesAutoloader($className){
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classPath = trim($classPath, DIRECTORY_SEPARATOR);

    $classFullPath = ROOT . DIRECTORY_SEPARATOR . "$classPath.php";
    if(file_exists($classFullPath)){
        return include_once $classFullPath;
    }
    return false;
}

function render($file, array $content)
{
    ob_start();
    extract($content);
    include $file;
    return trim(ob_get_clean());
}

function generate($length = 128, ...$arguments)
{
    if(!$arguments){
        $arguments = [
            range(0, 9),
            range('a', 'z'),
            range('A', 'Z')
        ];
    }

    $arguments = array_merge(...$arguments);
    $max = count($arguments)-1;

    $gen = '';
    for ($i = 0; $i < $length; $i++) {
        $gen .= $arguments[rand(0, $max)];
    }

    return $gen;
}