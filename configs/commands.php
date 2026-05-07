<?php

return [
    'home:test' => [\Controllers\Home\Console\IndexCommand::class, 'exec'],
    'home:test {first}:{second}' => [\Controllers\Home\Console\IndexCommand::class, 'exec'],
];