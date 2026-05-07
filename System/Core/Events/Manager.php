<?php

namespace System\Core\Events;

class Manager
{
    protected $event;
    protected $arguments = [];
    protected $events = [];

    public function __construct($event, $arguments, &$events)
    {
        $this->event = $event;
        $this->arguments = $arguments;
        $this->events = &$events;
    }

    public function add($class, $method = 'exec', $active = true)
    {
        $this->events[$this->event][] = [
            'class' => $class,
            'method' => $method,
            'status' => $active,
            'arguments' => $this->arguments,
        ];
    }

    public function run()
    {
        if(isset($this->events[$this->event])){
            foreach($this->events[$this->event] as $event){
                $this->runEvent($event);
            }
        }
    }

    protected function runEvent(array $event)
    {
        if(!$event['status']){ return false; }

        if(method_exists($event['class'], $event['method'])){
            $eventObject = new $event['class'](...$this->arguments);

            return call_user_func_array([$eventObject, $event['method']], $event['arguments']);
        }

        return false;
    }
}