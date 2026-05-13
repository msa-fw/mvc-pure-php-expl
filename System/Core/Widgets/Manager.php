<?php

namespace System\Core\Widgets;

use System\Core;

class Manager
{
    protected $widget;
    protected $requestUri;
    protected $arguments = [];
    protected $widgets = [];

    protected $debugger;

    public function __construct($widget, $arguments, &$widgets, $requestUri = null)
    {
        $this->widget = mb_strtolower($widget);
        $this->arguments = $arguments;
        $this->widgets = &$widgets;
        $this->requestUri = $requestUri;

        $this->debugger = Core::Debugger();
    }

    public function add($class, $method = 'exec', $active = true)
    {
        $builder = new Builder($this->arguments, $this->widgets[$this->widget]);
        $builder->handler($class, $method);
        $builder->template(str_replace('\\', '/', $class) . ucfirst($this->widget));

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

    public function executeWidget(array $widget)
    {
        if($widget['enabledUris'] && !$this->checkCurrentUri($widget['enabledUris'])){
            return null;
        }
        if($widget['disabledUris'] && $this->checkCurrentUri($widget['disabledUris'])){
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

    protected function checkCurrentUri(array $urisList)
    {
        foreach($urisList as $uri){
            $uri = ltrim($uri, '/');
            if(preg_match("#^\/$uri#usm", $this->requestUri)){
                return true;
            }
        }
        return false;
    }
}