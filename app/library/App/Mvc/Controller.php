<?php

namespace App\Mvc;

use App\Constant\Service;
use PhalconRest\Mvc\Controllers\FractalController;

/**
 * App\Mvc\Controllers
 *
 * @property \PhalconRest\Http\Request $request;
 * @property \PhalconRest\Http\Response $response;
 * @property \PhalconRest\Auth\Manager $authManager
 * @property \PhalconRest\Auth\TokenParser $tokenParser
 * @property \App\Service\UserService $userService
 * @property mixed $config
 */
class Controller extends FractalController
{
    /** @var \User Currently logged in user */
    protected $user;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->user = $this->userService->getUser();
    }
}