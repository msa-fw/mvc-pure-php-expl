<?php

namespace System\Core\Template;

use System\Core\Config;
use System\Core\Request;
use System\Core\Response;

class JSON implements CommonInterface
{
    protected $config;
    protected $request;
    protected $response;

    public function __construct(Config $config, Request $request, Response $response)
    {
        $this->config = $config;
        $this->request = $request;
        $this->response = $response;
    }

    public function render()
    {
        $this->response->header('Content-Type', 'application/json');
        return json_encode($this->response->content()->read([]), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}