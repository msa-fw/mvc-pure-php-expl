<?php

namespace System\Core;

use System\Core;
use System\Helpers\Traits\Collect;
use System\Helpers\Classes\Search;
use function module\loadControllersOptions;

/**
 * Class Config
 * @package System\Core
 *
 * @method Search template(...$_)
 * @method Search session(...$_)
 * @method Search database(...$_)
 * @method Search general(...$_)
 * @method Search controller(...$_)
 */
class Config
{
    use Collect;

    public function initialize()
    {
        Core::Events()->beforeConfigInitialized()->run();

        loadControllersOptions('config.php');

        Core::Events()->afterConfigInitialized()->run();
    }
}