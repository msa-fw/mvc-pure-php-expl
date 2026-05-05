<?php

function dbg(...$_)
{
    print "<pre>";
    foreach($_ as $arg){
        print_r($arg);
        print "<hr>";
    }
    exit("</pre>");
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