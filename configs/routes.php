<?php

return [
    '/' => \Controllers\Home\Actions\Index::class,
    '/home/' => \Controllers\Home\Actions\Index::class,
    '/home/{id}/' => \Controllers\Home\Actions\Index::class,
    '/home/{id}/{sub}/' => \Controllers\Home\Actions\Index::class,
];