<?php

namespace System\Core\Widgets;

class Builder
{
    protected $index = 0;
    protected $widgets = [];

    public function __construct($arguments, &$widgets)
    {
        if($widgets){
            $keys = array_keys($widgets);
            $this->index = end($keys) + 1;
        }

        $this->widgets = &$widgets[$this->index];

        $this->widgets = [
            'class' => null,
            'method' => null,
            'template' => null,
            'status' => null,
            'arguments' => $arguments,
            'options' => [
                'title' => null,
                'showTitle' => true,
                'enabledUris' => [],
                'disabledUris' => [],
                'enabledUserRoles' => [],
                'disabledUserRoles' => [],
            ]
        ];
    }

    /**
     * @param $class
     * @param string $method
     * @return self
     */
    public function handler($class, $method = 'exec')
    {
        $this->widgets['class'] = $class;
        $this->widgets['method'] = $method;

        return $this;
    }

    /**
     * @param $template
     * @return self
     */
    public function template($template)
    {
        $this->widgets['template'] = $template;
        return $this;
    }

    /**
     * @param bool $trigger
     * @return self
     */
    public function enabled($trigger = true)
    {
        $this->widgets['status'] = $trigger;
        return $this;
    }

    /**
     * @param array ...$links
     * @return self
     */
    public function enabledUris(...$links)
    {
        $this->option('enabledUris', $links);
        return $this;
    }

    /**
     * @param array ...$links
     * @return self
     */
    public function disabledUris(...$links)
    {
        $this->option('disabledUris', $links);
        return $this;
    }

    /**
     * @param array ...$roles
     * @return self
     */
    public function enabledUserRoles(...$roles)
    {
        $this->option('enabledUserRoles', $roles);
        return $this;
    }

    /**
     * @param array ...$roles
     * @return self
     */
    public function disabledUserRoles(...$roles)
    {
        $this->option('disabledUserRoles', $roles);
        return $this;
    }

    /**
     * @param $title
     * @param bool $showTitle
     * @return self
     */
    public function title($title, $showTitle = true)
    {
        $this->option('title', $title);
        $this->option('showTitle', $showTitle);

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return self
     */
    public function option($key, $value)
    {
        $this->widgets['options'][$key] = $value;
        return $this;
    }
}