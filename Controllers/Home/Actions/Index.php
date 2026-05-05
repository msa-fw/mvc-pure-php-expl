<?php

namespace Controllers\Home\Actions;

use Controllers\Home\HomeController;

class Index extends HomeController
{
    public function get()
    {
        $this->redirect('https://google.com');

        $this->response->content()->write([
            'method' => __METHOD__,
            'arguments' => func_get_args(),
            'request' => $this->request->request('id')->read(), // if URL equal to https://my.site/home/21/45?id=456
        ]);
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