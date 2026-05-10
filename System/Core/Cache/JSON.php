<?php

namespace System\Core\Cache;

use function filesystem\scan_callback;
use System\Core;
use System\Helpers\Classes\Search;

class JSON implements CommonInterface
{
    protected $directory;

    protected $ttl;
    protected $enabled;

    protected $debugger;

    public function __construct(Search $config, ...$keys)
    {
        $this->debugger = Core::Debugger();

        $this->ttl = $config->find('ttl')->read(300);
        $this->enabled = $config->find('enabled')->read();

        $keys = implode(DIRECTORY_SEPARATOR, $keys);
        $this->directory = ROOT . "/../tmp/cache/json/{$keys}";

        if(!is_dir($this->directory)){
            mkdir($this->directory, 0755, true);
        }
    }

    public function get($key)
    {
        $file = $this->file($key);

        if($this->enabled && file_exists($file)){
            if(filemtime($file) + $this->ttl > time()){
                $debugger = $this->debugger->cache()->start($key);

                $content = file_get_contents($file);
                $content = json_decode($content, true);

                $debugger->end();
                return $content;
            }
            $this->drop($key);
        }
        return [];
    }

    public function set($key, $value)
    {
        if($this->enabled){
            return file_put_contents($this->file($key), json_encode($value));
        }
        return false;
    }

    public function drop($key)
    {
        return unlink($this->file($key));
    }

    public function clear()
    {
        scan_callback($this->directory, function($directory, $file, $isDirectory){
            $path = $directory;
            if($file){ $path .= "/{$file}"; }

            if(file_exists($path)){
                if($isDirectory){
                    return rmdir($path);
                }
                return unlink($path);
            }
            return null;
        });
        return $this;
    }

    protected function file($key)
    {
        $key = preg_replace("#\s+#usim", '', $key);
        $hash = md5($this->directory . $key);
        return "{$this->directory}/{$hash}.json";
    }
}