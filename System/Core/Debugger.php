<?php

namespace System\Core;

use System\Core\Debugger\Builder;

/**
 * Class Debugger
 * @package System\Core
 *
 * @method Builder cache()
 * @method Builder database()
 * @method Builder events()
 * @method Builder widgets()
 */
class Debugger
{
    protected $debug = [];

    public function __call($name, $arguments)
    {
        return $this->run($name);
    }

    public function __construct()
    {
    }

    public function run($component)
    {
        return new Builder($this->debug[$component]);
    }

    public function getAll()
    {
        return $this->debug;
    }
}