<?php

namespace Controllers\Home\Actions;

use Controllers\Home\HomeController;

class Index extends HomeController
{
    public function __construct()
    {}

    public function get()
    {
        dbg(__METHOD__, func_get_args());
        return true;
    }

    public function post()
    {
        return false;
    }

    public function put()
    {
        return false;
    }

    public function head()
    {
        return false;
    }

    public function options()
    {
        return false;
    }

    public function patch()
    {
        return false;
    }

    public function delete()
    {
        return false;
    }

    public function connect()
    {
        return false;
    }

    public function trace()
    {
        return false;
    }
}