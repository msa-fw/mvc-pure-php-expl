<?php

namespace Controllers\Home;

use System\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->response->code()->write(401);    // @example: access denied error
    }

    public function simple()
    {
        dbg(__METHOD__);
        $this->response->template()->write('Controllers/Home/Actions/IndexAction');
        return true;
    }
}