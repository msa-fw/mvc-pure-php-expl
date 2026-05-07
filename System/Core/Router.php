<?php

namespace System\Core;

use ReflectionMethod;
use System\Core;
use function module\loadControllersOptions;

class Router
{
    protected $requestUri;
    protected $requestMethod;

    protected $routes = [];

    protected $response;

    public function __construct($requestMethod, $requestUri)
    {
        $this->response = Core::Response();

        $this->requestMethod = $requestMethod;

        $requestUri = '/' . trim($requestUri, '/');
        $this->requestUri = parse_url($requestUri, PHP_URL_PATH);

        $this->routes = loadControllersOptions('routes.php');
    }

    public function start()
    {
        foreach($this->routes as $uri => $class){
            $pattern = $this->uri2pattern($uri);
            if(preg_match($pattern, $this->requestUri, $match) && $this->runController($class, $this->requestMethod, array_slice($match, 1))){
                return true;
            }
        }
        $this->response->code()->write(404);
        return false;
    }

    protected function runController($className, $method, array $arguments = [])
    {
        if(!method_exists($className, $method)){
            return false;
        }

        if(count($arguments) < $this->getRequiredParams($className, $method)){
            return false;
        }

        $this->response->class()->write($className);
        $this->response->template()->write(str_replace('\\', DIRECTORY_SEPARATOR, $className));

        $object = new $className();
        return call_user_func_array([$object, $method], $arguments);
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