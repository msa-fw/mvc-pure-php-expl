<?php

namespace System\Core\Widgets;

use System\Core;

class Manager
{
    protected $widget;
    protected $arguments = [];
    protected $widgets = [];

    protected $debugger;

    public function __construct($widget, $arguments, &$widgets)
    {
        $this->widget = mb_strtolower($widget);
        $this->arguments = $arguments;
        $this->widgets = &$widgets;

        $this->debugger = Core::Debugger();
    }

    public function add($class, $method = 'exec', $active = true)
    {
        $builder = new Builder($this->arguments, $this->widgets[$this->widget]);
        $builder->handler($class, $method);
        return $builder->enabled($active);
    }

    public function run()
    {
        if(isset($this->widgets[$this->widget])){
            foreach($this->widgets[$this->widget] as $index => $widget){
                $this->widgets[$this->widget][$index]['result'] = [];

                if(!$widget['status']){ continue; }

                if($result = $this->executeWidget($widget)){
                    $this->widgets[$this->widget][$index]['result'] = $result;
                }
            }
            return $this->widgets[$this->widget];
        }
        return [];
    }

    protected function executeWidget(array $widget)
    {
        $requestUri = urldecode($_SERVER['REQUEST_URI']);
        $requestUri = parse_url($requestUri, PHP_URL_PATH);
        $requestUri = trim($requestUri, '/');

        if($widget['enabledUris'] && !$this->checkCurrentUri($requestUri, $widget['enabledUris'])){
            return null;
        }
        if($widget['disabledUris'] && $this->checkCurrentUri($requestUri, $widget['disabledUris'])){
            return null;
        }


        $result = null;
        $debugger = $this->debugger->widgets()->start("{$this->widget} => {$widget['class']}::{$widget['method']}");

        if(method_exists($widget['class'], $widget['method'])){
            $widgetObject = new $widget['class'](...$this->arguments);

            $result = call_user_func_array([$widgetObject, $widget['method']], $widget['arguments']);
        }

        $debugger->end();
        return $result;
    }

    protected function checkCurrentUri($current, array $urisList)
    {
        foreach($urisList as $uri){
            $uri = ltrim($uri, '/');
            if(preg_match("#^$uri#usm", $current)){
                return true;
            }
        }
        return false;
    }
}