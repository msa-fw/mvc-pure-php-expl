<?php

namespace Controllers\Home\Console;

use System\Core\Console\Dialog;
use function console\danger;
use function console\success;

class DialogTestCommand
{
    protected $command;
    protected $params = [];
    
    protected $answer = 'Oooo Nanananana';
    protected $question = 'How are you?';

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function exec()
    {
        $dialog = new Dialog($this->question);

        $dialog->validate(function($answer){
            return $answer == $this->answer;
        });

        if(!$dialog->valid()){
            print danger("Fail! Try again...");
            return $this->exec();
        }

        print success("Ok)");
        return true;
    }
}