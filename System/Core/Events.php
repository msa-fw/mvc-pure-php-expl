<?php

namespace System\Core;

use System\Core\Events\Manager;
use function module\loadControllersOptions;

/**
 * Class Events
 * @package System\Core
 *
 * @method Manager beforeConfigInitialized(...$_)
 * @method Manager afterConfigInitialized(...$_)
 *
 * @method Manager beforeSessionStart(...$_)
 * @method Manager afterSessionStart(...$_)
 *
 * @method Manager beforeControllerStart(...$_)
 * @method Manager afterControllerStart(...$_)
 *
 * @method Manager beforeCommandStart(...$_)
 * @method Manager afterCommandStart(...$_)
 *
 * @method Manager beforeTemplateRender(...$_)
 * @method Manager afterTemplateRender(...$_)
 */
class Events
{
    protected $events = [];

    public function __call($name, $arguments)
    {
        return $this->run($name, ...$arguments);
    }

    public function __construct()
    {
    }

    public function initialize()
    {
        loadControllersOptions('events.php');
    }

    public function run($event, ...$arguments)
    {
        return new Manager($event, $arguments, $this->events);
    }
}