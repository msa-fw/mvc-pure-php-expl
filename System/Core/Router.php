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

    protected $config;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->request = Core::Request();
        $this->response = Core::Response();

        $this->requestUri = $this->request->uri('path')->read('/');
        $this->requestMethod = $this->request->server('request-method')->read('');

        $this->routes = loadControllersOptions('routes.php');
    }

    public function start()
    {
        foreach($this->routes as $uri => $action){
            list($class, $method) = $action;
            $method = $method ?: $this->requestMethod;

            $pattern = $this->uri2pattern($uri);
            if(preg_match($pattern, $this->requestUri, $match) && $this->runController($class, $method, array_slice($match, 1))){
                return true;
            }
        }
        $this->response->code()->write(404);
        return false;
    }

    public function runController($className, $method, array $arguments = [])
    {
        if(!$this->checkControllerActiveStatus($className)){
            return false;
        }

        if(!method_exists($className, $method)){
            return false;
        }

        if(count($arguments) < $this->getRequiredParams($className, $method)){
            return false;
        }

        $this->response->class()->write($className);
        $this->response->template()->write(str_replace('\\', DIRECTORY_SEPARATOR, $className));

        Core::Events()->beforeControllerStart()->run();

        $object = new $className();
        $result = call_user_func_array([$object, $method], $arguments);

        Core::Events()->afterControllerStart()->run();

        return $result;
    }

    protected function checkControllerActiveStatus($className)
    {
        if(preg_match("#Controllers\\\\(\w+)#usim", $className, $match)){
            return $this->config->controller($match[1], 'active')->read();
        }
        return true;
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