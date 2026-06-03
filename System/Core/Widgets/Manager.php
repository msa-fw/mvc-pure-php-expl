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
    protected $session;

    public function __construct($widget, $arguments, &$widgets, $requestUri = null)
    {
        $this->widget = mb_strtolower($widget);
        $this->arguments = $arguments;
        $this->widgets = &$widgets;
        $this->requestUri = $requestUri;

        $this->debugger = Core::Debugger();
        $this->session = Core::Session();
    }

    public function add($class, $method = 'exec', $active = true)
    {
        $builder = new Builder($this->arguments, $this->widgets[$this->widget]);
        $builder->handler($class, $method);
        $builder->template(str_replace('\\', '/', $class) . '/' . $this->widget);

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
        if(!$this->checkWidgetAccess($widget)){ return null; }

        $result = null;
        $debugger = $this->debugger->widgets()->start("{$this->widget} => {$widget['class']}::{$widget['method']}");

        if(method_exists($widget['class'], $widget['method'])){
            $widgetObject = new $widget['class'](...$this->arguments);

            $result = call_user_func_array([$widgetObject, $widget['method']], $widget['arguments']);
        }

        $debugger->end();
        return $result;
    }

    protected function checkWidgetAccess(array $widget)
    {
        if($widget['options']['enabledUris'] && !$this->checkCurrentUri($widget['options']['enabledUris'])){
            return false;
        }

        if($widget['options']['disabledUris'] && $this->checkCurrentUri($widget['options']['disabledUris'])){
            return false;
        }

        if($widget['options']['enabledUserRoles'] && !$this->checkUserRoles($widget['options']['enabledUserRoles'])){
            return false;
        }

        if($widget['options']['disabledUserRoles'] && $this->checkUserRoles($widget['options']['disabledUserRoles'])){
            return false;
        }
        return true;
    }

    protected function checkUserRoles(array $roles)
    {
        $userRoles = $this->session->user('roles')->read([]);
        foreach($roles as $role){
            if(in_array($role, $userRoles)){ return true; }
        }
        return false;
    }

    protected function checkCurrentUri(array $patterns)
    {
        foreach($patterns as $pattern){
            if(preg_match("#$pattern#usm", $this->requestUri)){
                return true;
            }
        }
        return false;
    }
}