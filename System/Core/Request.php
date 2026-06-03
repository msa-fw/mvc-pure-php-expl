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
 * @method Search server(...$_)
 *
 * @method Search uri(...$_)
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

        $this->setHeaders();
    }

    protected function setHeaders() {
        foreach($_SERVER as $name => $value){
            $header = strtolower($name);
            $header = str_replace('_', '-', $header);
            if(preg_match("#^http-(.*?)$#usm", $header, $match)){
                $this->headers($match[1])->write($value);
            }else{
                $this->server($header)->write($value);

                if($header == 'request-uri'){
                    $this->setRequestUri($value);
                }
            }
        }
        return $this;
    }

    public function setRequestUri($requestUri)
    {
        $requestUri = urldecode($requestUri);
        $this->uri()->write(parse_url($requestUri));

        return $this;
    }
}