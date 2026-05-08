<?php

namespace System\Core\Console;

class Dialog
{
    protected $valid;
    protected $answer;

    public function __construct($question)
    {
        print $question . ": > ";
        $this->answer = trim(fgets(STDIN));
        return $this;
    }

    public function validate(callable $function)
    {
        $this->valid = call_user_func($function, $this->answer);
        return $this;
    }

    public function answer()
    {
        return $this->answer;
    }

    public function valid()
    {
        return $this->valid;
    }
}