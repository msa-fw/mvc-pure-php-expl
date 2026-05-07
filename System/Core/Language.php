<?php

namespace System\Core;

use System\Core;
use function module\loadLanguagePack;

class Language
{
    protected $config;
    protected $language;

    public function __construct()
    {
        $this->config = Core::Config();

        $language = $this->config->general('language')->read('en');
        $this->language = loadLanguagePack($language);
    }

    public function get($key)
    {
        return isset($this->language[$key]) ? $this->language[$key] : null;
    }

    public function getAll()
    {
        return $this->language;
    }
}