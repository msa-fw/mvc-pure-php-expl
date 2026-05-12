<?php

namespace System\Core;

use System\Core\Widgets\Manager;
use function module\loadControllersOptions;

/**
 * Class Widgets
 * @package System\Core
 *
 * @method Manager header(...$_)
 * @method Manager top(...$_)
 * @method Manager body(...$_)
 * @method Manager leftbar(...$_)
 * @method Manager rightbar(...$_)
 * @method Manager bottom(...$_)
 * @method Manager footer(...$_)
 */
class Widgets
{
    protected $widgets = [];

    public function __call($name, $arguments)
    {
        return $this->run($name, ...$arguments);
    }

    public function __construct()
    {
    }

    public function initialize()
    {
        loadControllersOptions('widgets.php');
    }

    public function run($widget, ...$arguments)
    {
        return new Manager($widget, $arguments, $this->widgets);
    }
}