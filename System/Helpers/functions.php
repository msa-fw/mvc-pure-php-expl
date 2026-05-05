<?php

function dbg(...$_)
{
    print "<pre>";
    foreach($_ as $arg){
        print_r($arg);
        print "<hr>";
    }
    print "</pre>";
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
        $arguments = array(range(0, 9), range('a', 'z'), range('A', 'Z'));
    }

    $arguments = array_merge(...$arguments);
    $max = count($arguments)-1;

    $gen = '';
    for ($i = 0; $i < $length; $i++) {
        $gen .= $arguments[rand(0, $max)];
    }

    return $gen;
}