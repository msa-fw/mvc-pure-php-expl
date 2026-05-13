<?php

use System\Core;

Core::Events()->beforeTemplateRender()->add(\Controllers\Home\Events\ResponseEvent::class, 'setAllowedRequestMethods');
Core::Events()->beforeTemplateRender()->add(\Controllers\Home\Events\RequestEvent::class, 'setRenderTypeFromAcceptHeader');
Core::Events()->beforeControllerStart()->add(\Controllers\Home\Events\RequestEvent::class, 'detectLanguageFromHeader');
