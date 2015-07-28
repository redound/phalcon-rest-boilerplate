<?php

use Library\App\Constants\Services as AppServices;
use Library\PhalconRest\Transformers\UserTransformer;

/**
 * @resource("User")
 */
class UserController extends \PhalconRest\Mvc\Controller
{
    /**
     * @title("Activate")
     * @description("Activate user via activation-link")
     * @response("Result object or Error object")
     * @requestExample("GET /users/activate?mailtoken=2df14qh9of4qas98fynasd9")
     * @responseExample({
     *      "result": "OK"
     *  })
     */
    public function onConstruct()
    {
        parent::onConstruct();

        $this->userService = $this->di->get(AppServices::USER_SERVICE);
    }

    public function activate()
    {
        $user = $this->userService->activate();

        return $this->createItem($user, new \UserTransformer, 'user');
    }

    /**
     * @title("Register")
     * @description("Register new user")
     * @response("User object or Error object")
     * @requestExample({
     *      "name": "John Doe",
     *      "email": "john@doe.com",
     *      "password": "supersecretpassword"
     * })
     * @responseExample({
     *     "user": {
     *         "id": 14,
     *         "name": "John Doe",
     *         "email": "john@doe.com",
     *         "dateRegistered": 1427896235000,
     *         "active": 0,
     *         "accountTypeIds": "1"
     *     }
     * })
     */
    public function register($account)
    {
        $data = $this->request->getJsonRawBody();

        $user = $this->userService->register($account, $data);

        return $this->createItem($user, new \UserTransformer, 'user');
    }

    /**
     * @title("Me")
     * @description("Get the current user")
     * @includeTypes({
     *      "accounts": "Adds accounts object to the response"
     * })
     * @requestExample("GET /users/me?include=accounts")
     * @response("User object or Error object")
     * @responseExample({
     *     "user": {
     *         "id": 14,
     *         "name": "John Doe",
     *         "email": "john@doe.com",
     *         "dateRegistered": 1427646703000,
     *         "active": 1,
     *         "accountTypeIds": "1,2",
     *         "accounts": {
     *             "google": {
     *                 "id": 3,
     *                 "userId": 14,
     *                 "googleId": 9223372036854776000,
     *                 "email": "john@doe.com"
     *             },
     *             "username": {
     *                 "id": 12,
     *                 "userId": 14,
     *                 "username": "john"
     *             }
     *         }
     *     }
     * })
     */
    public function me()
    {

        $user = $this->userService->me();

        return $this->createItem($user, new \UserTransformer, 'user');
    }

    /**
     * @title("Delete")
     * @description("Delete user")
     * @response("Result object or Error object")
     * @requestExample("GET /users/me/delete")
     * @responseExample({
     *      "result": "OK"
     *  })
     */
    public function delete()
    {
        $this->userService->delete();
        return $this->respondWithOK();
    }

    /**
     * @title("Authenticate")
     * @description("Authenticate user")
     * @headers({
     *      "Authorization": "'Basic sd9u19221934y='(base64 encoded username and password or code and access_token received from google client authentication)"
     * })
     * @response("Data object or Error object")
     * @responseExample({
     *      "data": {
     *          "AuthToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
     *          "Expires": 1428497770000
     *      }
     *  })
     */
    public function authenticate($account)
    {
        return $this->respondWithArray($this->userService->login($account), 'data');
    }

}
