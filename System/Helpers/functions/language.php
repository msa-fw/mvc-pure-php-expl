<?php

namespace language;

use System\Core;

function translate($key, array $replacement = [], $returnKey = false)
{
    $language = Core::Language();
    if($value = $language->get($key)){
        return str_replace(array_keys($replacement), array_values($replacement), $value);
    }
    return $returnKey ? $key : '';
}