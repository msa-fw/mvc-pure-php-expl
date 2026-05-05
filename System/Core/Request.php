<?php

namespace System\Core;

use System\Helpers\Traits\Collect;
use System\Helpers\Classes\Search;

/**
 * Class Request
 * @package System\Core
 *
 * @method Search get(...$_)
 * @method Search post(...$_)
 * @method Search request(...$_)
 */
class Request
{
    use Collect;

    public function __construct()
    {
        $this->get()->write($_GET);
        $this->post()->write($_POST);
        $this->request()->write($_REQUEST);
    }
}