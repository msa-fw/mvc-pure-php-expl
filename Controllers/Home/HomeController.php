<?php

namespace Controllers\Home;

use System\Core\Controller;

class HomeController extends Controller
{
    public function simple()
    {
        dbg(__METHOD__);
        $this->response->template()->write('Controllers/Home/Actions/IndexAction');
        return true;
    }
}