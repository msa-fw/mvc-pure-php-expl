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
 * @method Search class()
 * @method Search template()
 */
class Response
{
    use Collect;

    public function __construct()
    {
        $this->code()->write(200);
    }

    public function header($key, $value)
    {
        $this->headers($key)->write($value);
        return $this;
    }
}