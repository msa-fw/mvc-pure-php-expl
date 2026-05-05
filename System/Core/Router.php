<?php

namespace System\Core;

use ReflectionMethod;

class Router
{
    protected $requestUri;
    protected $requestMethod;

    protected $routes = [];

    public function __construct($requestMethod, $requestUri)
    {
        $this->requestMethod = $requestMethod;

        $requestUri = '/' . trim($requestUri, '/');
        $this->requestUri = parse_url($requestUri, PHP_URL_PATH);

        $this->routes = include ROOT . "/configs/routes.php";
    }

    public function start()
    {
        foreach($this->routes as $uri => $class){
            $pattern = $this->uri2pattern($uri);
            if(preg_match($pattern, $this->requestUri, $match)){
                if(!$this->runController($class, array_slice($match, 1))){
                    dbg(404);
                }
            }
        }
    }

    protected function runController($className, array $arguments = [])
    {
        if(!method_exists($className, $this->requestMethod)){
            return false;
        }

        if(count($arguments) < $this->getRequiredParams($className, $this->requestMethod)){
            return false;
        }

        $object = new $className();
        return call_user_func_array([$object, $this->requestMethod], $arguments);
    }

    protected function getRequiredParams($class, $method)
    {
        $reflection = new ReflectionMethod($class, $method);
        return $reflection->getNumberOfRequiredParameters();
    }

    protected function uri2pattern($uri)
    {
        $uri = '/' . trim($uri, '/');
        return preg_replace_callback_array(array(
            "#\{\p{L}+\}#usim" => function($match){ return '(\w+)'; },
            "#\[\p{L}+\]#usim" => function($match){ return '(\d+)'; },
        ), "#^$uri$#usim");
    }
}