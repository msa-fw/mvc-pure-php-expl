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
 *
 * @method Search files(...$_)
 * @method Search cookies(...$_)
 * @method Search headers(...$_)
 */
class Request
{
    use Collect;

    public function __construct()
    {
        $this->get()->write($_GET);
        $this->post()->write($_POST);
        $this->request()->write($_REQUEST);

        $this->files()->write($_FILES);
        $this->cookies()->write($_COOKIE);
        $this->headers()->write($this->getAllHeaders());
    }

    protected function getAllHeaders() {
        $headers = [];
        foreach($_SERVER as $name => $value){
            if(strpos($name, 'HTTP_') === 0){
                $header = substr($name, 5);
                $header = str_replace('_', '-', strtolower($header));
                $headers[$header] = $value;
            }
        }

        return $headers;
    }
}