<?php

namespace System\Core;

use System\Core;
use System\Core\Cache\JSON;
use System\Core\Cache\CommonInterface;

class Cache
{
    protected $root;
    protected $config;
    protected $driver;

    public function __construct($root)
    {
        $this->root = $root;
        $this->config = Core::Config()->cache();
        $this->driver = $this->config->find('driver')
            ->read(JSON::class);
    }

    /**
     * @param array ...$keys
     * @return CommonInterface
     */
    public function find(...$keys)
    {
        return new $this->driver($this->config, $this->root, ...$keys);
    }
}