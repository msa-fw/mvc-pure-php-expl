<?php

namespace System\Core;

use System\Core;
use System\Helpers\Traits\Collect;
use System\Helpers\Classes\Search;

/**
 * Class Session
 * @package System\Core
 *
 * @method Search user(...$_)
 * @method Search auth(...$_)
 * @method Search config(...$_)
 * @method Search messages(...$_)
 */
class Session
{
    use Collect;

    protected $newUser;
    protected $sessionName;
    protected $sessionDirectory;
    protected $sessionIdentifier;

    protected $config;
    protected $request;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->request = Core::Request();

        $this->sessionName = $this->config->session('sessionName')->read('');

        if(!($this->sessionIdentifier = $this->request->cookies($this->sessionName)->read())){
            $this->newUser = true;
            $this->sessionIdentifier = generate(64);
        }
    }

    public function initialize()
    {
        $sessionDirectory = $this->config->session('sessionDirectory')->read('');
        $this->sessionDirectory = ROOT . '/' . trim($sessionDirectory, '/');

        if(!is_dir($this->sessionDirectory)){
            mkdir($this->sessionDirectory, 0755, true);
        }

        ini_set('session.gc_maxlifetime', $this->config->session('sessionLifeTime')->read(300));
        ini_set('session.cookie_lifetime', $this->config->session('sessionLifeTime')->read(300));
        ini_set('session.cookie_domain', $this->config->session('sessionDomain')->read());

        session_name($this->sessionName);
        session_save_path($this->sessionDirectory);
        session_id($this->sessionIdentifier);
        session_start();

        $this->subject = &$_SESSION;

        return $this;
    }
}