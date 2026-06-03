<?php

namespace System;

/**
 * Class Core
 * @package System
 *
 * @method static|Core\Cache Cache()
 * @method static|Core\Config Config()
 * @method static|Core\Cron Cron()
 * @method static|Core\Database Database()
 * @method static|Core\Debugger Debugger()
 * @method static|Core\Events Events()
 * @method static|Core\Language Language()
 * @method static|Core\Request Request()
 * @method static|Core\Response Response()
 * @method static|Core\Session Session()
 * @method static|Core\Widgets Widgets()
 */
class Core
{
    private static $instances = [];

    public static function __callStatic($name, $arguments)
    {
        $class = "\\System\\Core\\$name";
        return self::get($class, ...$arguments);
    }

    public static function get($class, ...$arguments)
    {
        if(!isset(self::$instances[$class])){
            return self::set($class, null, ...$arguments);
        }
        return self::$instances[$class];
    }

    public static function set($class, object $object = null, ...$arguments)
    {
        self::$instances[$class] = is_object($object) ? $object : new $class(...$arguments);
        return self::$instances[$class];
    }

    public static function unset($class)
    {
        if(isset(self::$instances[$class])){
            unset(self::$instances[$class]);
            return true;
        }
        return false;
    }

}