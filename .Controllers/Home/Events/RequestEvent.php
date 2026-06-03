<?php

namespace Controllers\Home\Events;

use System\Core;

class RequestEvent
{
    protected $config;
    protected $request;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->request = Core::Request();
    }

    public function detectLanguageFromHeader()
    {
        $acceptLanguages = $this->request->headers('accept-language')->read('');
        if(preg_match_all("#\w+#usm", $acceptLanguages, $matches)){
            foreach($matches[0] as $match){
                if(file_exists(ROOT . "/Controllers/Home/languages/{$match}.php")){
                    $this->config->general('language')->write($match);
                    break;
                }
            }
        }
        return true;
    }

    public function setRenderTypeFromAcceptHeader()
    {
        $accept = $this->request->headers('accept')->read('');
        if(preg_match_all("#\w+#usm", $accept, $matches)){
            foreach($matches[0] as $match){
                $class = "\\System\\Core\\Template\\" . mb_strtoupper($match);
                if(class_exists($class)){
                    $this->config->template('renderClass')->write($class);
                    break;
                }
            }
        }
        return true;
    }
}