<?php

namespace Controllers\Home\Events;

use System\Core;

class ResponseEvent
{
    protected $config;
    protected $response;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->response = Core::Response();
    }

    public function setAllowedRequestMethods()
    {
        $allowedRequestMethods = $this->config->template('allowedRequestMethods')->read([]);
        $this->response->header('Allow', implode(', ', $allowedRequestMethods));
        return true;
    }
}