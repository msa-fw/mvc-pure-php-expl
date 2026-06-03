<?php

namespace System\Core\Debugger;

class Builder
{
    protected $index;

    protected $debug = [];

    public function __construct(&$debug)
    {
        $this->index = 0;
        if($this->debug = &$debug){
            $keys = array_keys($this->debug);
            $this->index = end($keys) + 1;
        }
    }

    public function start($query, array $arguments = [])
    {
        $arguments['query'] = $query;
        $arguments['start'] = $this->prepareTimer(microtime(true));
        $arguments['end'] = 0;
        $arguments['trace'] = array_reverse(debug_backtrace());

        $this->debug[$this->index] = $arguments;

        return $this;
    }

    public function end()
    {
        $this->debug[$this->index]['end'] = $this->prepareTimer(microtime(true));
    }

    protected function prepareTimer($value)
    {
        return number_format($value, 30, '.', '');
    }
}