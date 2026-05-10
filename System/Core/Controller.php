<?php

namespace System\Core;

use System\Core;

abstract class Controller
{
    protected $limit = 30;
    protected $offset = 0;

    protected $request;
    protected $response;

    protected $model;

    public function __construct()
    {
        $this->request = Core::Request();
        $this->response = Core::Response();

        $this->offset = $this->request->request('offset')->call(function($value){
            return is_numeric($value) ? $value : 0;    // @fix possible SQL-injection
        })->read(0);
    }

    public function redirect($link)
    {
        $this->response->code()->write(302);
        $this->response->header('Location', $link);
        return $this;
    }
}