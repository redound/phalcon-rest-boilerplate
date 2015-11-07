<?php

use Library\App\Constants\Services as AppServices;
use Library\PhalconRest\Transformers\UserTransformer;

/**
 * @resource("User")
 */
class UserController extends \App\Mvc\Controller
{
    /**
     * @title("Me")
     * @description("Get the current user")
     * @includeTypes({
     *      "accounts": "Adds accounts object to the response"
     * })
     * @requestExample("GET /users/me")
     * @response("User object or Error object")
     */
    public function me()
    {
        return $this->respondItem($this->user, new \UserTransformer, 'user');
    }


    /**
     * @title("Authenticate")
     * @description("Authenticate user")
     * @headers({
     *      "Authorization": "'Basic sd9u19221934y='"
     * })
     * @requestExample("POST /users/authenticate")
     * @response("Data object or Error object")
     */
    public function authenticate()
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        $session = $this->authManager->loginWithUsernamePassword(\App\Auth\UsernameAccountType::NAME, $username, $password);
        $response = [
            'token' => $session->getToken(),
            'expires' => $session->getExpirationTime()
        ];

        return $this->respondArray($response, 'data');
    }
}
