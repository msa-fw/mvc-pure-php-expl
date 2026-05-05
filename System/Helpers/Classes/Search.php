<?php

namespace System\Helpers\Classes;

class Search
{
    protected $subject;

    public function __construct(&$data)
    {
        $this->subject = &$data;
    }

    public function find(...$keys)
    {
        $clone = $this;
        foreach($keys as $key){
            $clone = new self($clone->subject[$key]);
        }
        return $clone;
    }

    public function read($alt = null)
    {
        return $this->subject ? $this->subject : $alt;
    }

    public function write($value)
    {
        $this->subject = $value;
        return $this;
    }

    public function drop()
    {
        $this->subject = null;
        return $this;
    }

    public function exist($strict = true)
    {
        return $strict ? isset($this->subject) && !empty($this->subject) : isset($this->subject);
    }

    public function call(callable $callback, ...$_)
    {
        $this->subject = call_user_func($callback, $this->subject, ...$_);
        return $this;
    }
}