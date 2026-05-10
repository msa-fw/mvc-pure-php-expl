<?php

namespace System\Core\Cache;

interface CommonInterface
{
    public function get($key);

    public function set($key, $value);

    public function drop($key);

    public function clear();
}