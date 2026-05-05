<?php

namespace System;

/**
 * Class Core
 * @package System
 *
 * @method static|Core\Request Request()
 * @method static|Core\Response Response()
 */
class Core
{
    private static $instances = [];

    public static function __callStatic($name, $arguments)
    {
        if(!isset(static::$instances[$name])){
            $className = "\\System\\Core\\$name";
            static::$instances[$name] = new $className(...$arguments);
        }
        return static::$instances[$name];
    }
}