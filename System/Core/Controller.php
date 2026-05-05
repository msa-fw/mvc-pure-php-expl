<?php

namespace System\Core;

use System\Core;

class Controller
{
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->request = Core::Request();
        $this->response = Core::Response();
    }

    public function redirect($link)
    {
        $this->response->code()->write(302);
        $this->response->header('Location', $link);
        return $this;
    }
}