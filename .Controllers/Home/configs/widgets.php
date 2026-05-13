<?php

use System\Core;

Core::Widgets()->top()->add(\Controllers\Home\Widgets\SimpleWidget::class)->enabledUris('^/home$');
