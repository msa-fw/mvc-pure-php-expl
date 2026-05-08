<?php

namespace Controllers\Home\Console;

use System\Core\Console\Dialog;
use function console\danger;
use function console\success;

class DialogTestCommand
{
    protected $answer = 'Oooo Nanananana';
    protected $question = 'How are you?';

    public function __construct()
    {
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