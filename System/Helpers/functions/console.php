<?php

namespace console;

function text($message, $color)
{
    return "\e[1;{$color}m{$message}\e[0m" . PHP_EOL;
}

function danger($message)
{
    return text($message, 41);
}

function success($message)
{
    return text($message, 42);
}

function warning($message)
{
    return text($message, 43);
}