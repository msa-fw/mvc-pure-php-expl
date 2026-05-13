<?php

namespace System\Core;

use System\Helpers\Traits\Collect;
use System\Helpers\Classes\Search;

/**
 * Class Response
 * @package System\Core
 *
 * @method Search code()
 * @method Search content(...$_)
 * @method Search headers(...$_)
 *
 * @method Search template()
 * @method Search controller()
 * @method Search controllerName()
 */
class Response
{
    use Collect;

    public function __construct()
    {
        $this->code()->write(404);
    }

    public function header($key, $value)
    {
        $this->headers($key)->write($value);
        return $this;
    }
}