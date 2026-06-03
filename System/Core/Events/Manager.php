<?php

namespace System\Core\Events;

use System\Core;

class Manager
{
    protected $event;
    protected $arguments = [];
    protected $events = [];

    protected $debugger;

    public function __construct($event, $arguments, &$events)
    {
        $this->event = $event;
        $this->arguments = $arguments;
        $this->events = &$events;

        $this->debugger = Core::Debugger();
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
                if(!$event['status']){ continue; }
                $this->runEvent($event);
            }
        }
    }

    public function runEvent(array $event)
    {
        $result = null;
        $debugger = $this->debugger->events()->start("{$this->event} => {$event['class']}::{$event['method']}");

        if(method_exists($event['class'], $event['method'])){
            $eventObject = new $event['class'](...$this->arguments);

            $result = call_user_func_array([$eventObject, $event['method']], $event['arguments']);
        }

        $debugger->end();
        return $result;
    }
}