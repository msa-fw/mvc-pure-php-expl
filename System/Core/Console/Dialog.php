<?php

namespace System\Core\Console;

class Dialog
{
    protected $valid;
    protected $answer;
    protected $question;

    public function __construct($question)
    {
        $this->question = $question;
    }

    public function validate(callable $function)
    {
        print $this->question . ": > ";
        $this->answer = trim(fgets(STDIN));
        $this->valid = call_user_func($function, $this->answer);
        return $this;
    }

    public function valid()
    {
        return $this->valid;
    }
}