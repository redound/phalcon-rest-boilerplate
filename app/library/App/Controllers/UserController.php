<?php

namespace App\Controllers;

use PhalconRest\Mvc\Controllers\CrudResourceController;

class UserController extends CrudResourceController
{
    public function me()
    {
        return $this->createResourceResponse($this->userService->getDetails());
    }

    public function authenticate()
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        $session = $this->authManager->loginWithUsernamePassword(\App\Auth\UsernameAccountType::NAME, $username,
            $password);
        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime()
        ];

        return $this->createArrayResponse($response, 'data');
    }
}
