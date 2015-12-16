<?php

use App\Constants\Services as AppServices;

$eventsManager = $di->get(AppServices::EVENTS_MANAGER);

/**
 * NotFound handler
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\NotFound);

/**
 * Authenticate user
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\Authentication);

/**
 * Authorize endpoints
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\Acl($config->acl->privateEndpoints, $config->acl->publicEndpoints));

/**
 * Fractal - Set includes
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\Fractal);

/**
 * Request - Allow OPTIONS
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\OptionsResponse);

/**
 * Queries - Process queries
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\UrlQuery);