<?php

return [
    '/' => \Controllers\Home\Actions\IndexAction::class,
    '/home/' => \Controllers\Home\Actions\IndexAction::class,
    '/home/{id}/' => \Controllers\Home\Actions\IndexAction::class,
    '/home/{id}/{sub}/' => \Controllers\Home\Actions\IndexAction::class,
];