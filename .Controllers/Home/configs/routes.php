<?php

return [
    '/' => [\Controllers\Home\Actions\IndexAction::class, null],
    '/home/' => [\Controllers\Home\Actions\IndexAction::class, null],
    '/home/{id}/' => [\Controllers\Home\Actions\IndexAction::class, null],
    '/home/{id}/{sub}' => [\Controllers\Home\Actions\IndexAction::class, null],
//    '/home/{id}/{sub}/' => [\Controllers\Home\HomeController::class, 'simple'],
];