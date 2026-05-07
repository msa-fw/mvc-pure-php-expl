<?php

namespace Controllers\Home\Console;

use function language\translate;

class IndexCommand
{
    public function __construct()
    {
    }

    public function exec($test, $second = true)
    {
        dbg([__METHOD__ => func_get_args()], translate('home.test'));
        return true;
    }
}