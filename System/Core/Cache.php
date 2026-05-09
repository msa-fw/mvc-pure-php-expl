<?php

namespace System\Core;

use System\Core;
use System\Core\Cache\CommonInterface;

class Cache
{
    protected $config;

    public function __construct()
    {
        $this->config = Core::Config()->cache();
    }

    /**
     * @param array ...$keys
     * @return CommonInterface
     */
    public function find(...$keys)
    {
        $driver = $this->config->find('driver')
            ->read(\System\Core\Cache\JSON::class);

        return new $driver($this->config, ...$keys);
    }
}