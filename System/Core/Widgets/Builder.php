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
            'enabledUris' => [],
            'disabledUris' => [],
            'arguments' => $arguments,
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
        $this->widgets['enabledUris'] = $links;
        return $this;
    }

    /**
     * @param array ...$links
     * @return self
     */
    public function disabledUris(...$links)
    {
        $this->widgets['disabledUris'] = $links;
        return $this;
    }
}