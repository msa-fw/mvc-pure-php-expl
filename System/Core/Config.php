<?php

namespace System\Core;

use System\Helpers\Traits\Collect;
use System\Helpers\Classes\Search;

/**
 * Class Config
 * @package System\Core
 *
 * @method Search template(...$_)
 * @method Search session(...$_)
 * @method Search database(...$_)
 */
class Config
{
    use Collect;

    public function initialize($configFile = "/configs/config.php")
    {
        include ROOT . $configFile;
    }
}