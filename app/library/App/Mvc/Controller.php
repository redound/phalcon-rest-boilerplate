<?php

namespace App\Mvc;

use App\Constant\Service;
use App\Service\UserService;

/**
 * App\Mvc\Controller
 *
 * @property \PhalconRest\Http\Request $request;
 * @property \PhalconRest\Http\Response $response;
 * @property \PhalconRest\Auth\Manager $authManager
 * @property \PhalconRest\Auth\TokenParser $tokenParser
 * @property \App\Service\UserService $userService
 * @property mixed $config
 */
class Controller extends \PhalconRest\Mvc\Controller\FractalController
{
    /** @var \User Currently logged in user */
    protected $user;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->user = $this->userService->getUser();
    }
}