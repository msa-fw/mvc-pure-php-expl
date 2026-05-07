<?php

namespace module;

function loadControllersOptions($filename)
{
    $result = [];
    foreach(glob(ROOT . "/Controllers/*/configs/$filename") as $file){
        $data = include $file;
        if(is_array($data)){
            $result[] = $data;
        }
    }
    return array_merge(...$result);
}

function loadLanguagePack($languageCode)
{
    $result = [];
    foreach(glob(ROOT . "/Controllers/*/languages/$languageCode.php") as $file){
        $result[] = include $file;
    }
    return array_merge(...$result);
}