<?php

namespace Controllers\__CONTROLLER__;

use System\Core\Controller;

class __CONTROLLER__Controller extends Controller
{
    public function simple()
    {
        $this->response->template()->write('Controllers/__CONTROLLER__/Actions/__CONTROLLER__Action');
        return true;
    }
}