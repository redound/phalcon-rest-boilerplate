<?php

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\Services as PhalconRestServices;

$eventsManager = $di->get(AppServices::EVENTS_MANAGER);

/**
 * NotFound handler
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\NotFound);

/**
 * XDomain for CORS (IE Fix) - https://github.com/jpillora/xdomain
 */
$xdomain = new \PhalconRest\Middleware\XDomain(AppServices::VIEW);
$xdomain->setRoute($config->xdomain->route);
$xdomain->setViewPath($config->xdomain->viewPath);
$xdomain->setHostName($config->clientHostName);

$eventsManager->attach('micro', $xdomain);

/**
 * Authenticate user
 */
$eventsManager->attach('micro', new \PhalconRest\Middleware\Authentication);

/**
 * Authorize endpoints
 */
$privateEndpoints = $config->acl->privateEndpoints;
$publicEndpoints = $config->acl->publicEndpoints;

$eventsManager->attach('micro', new \PhalconRest\Middleware\Acl($privateEndpoints, $publicEndpoints));

/**
 * Fractal - Set includes
 */
$fractal = new \PhalconRest\Middleware\Fractal(PhalconRestServices::FRACTAL_MANAGER, PhalconRestServices::REQUEST);

$eventsManager->attach('micro', $fractal);

/**
 * Request - Allow OPTIONS
 */
$request = new \PhalconRest\Middleware\Request(PhalconRestServices::REQUEST, PhalconRestServices::RESPONSE);

$eventsManager->attach('micro', $request);

/**
 * Response - Respond controller returned values
 */
$response = new \PhalconRest\Middleware\Response(PhalconRestServices::RESPONSE);
$eventsManager->attach('micro', $response);
