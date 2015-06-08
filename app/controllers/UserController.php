<?php

use PhalconRest\Exceptions\UserException,
    PhalconRest\Exceptions\CoreException,
    PhalconRest\Transformers\UserTransformer;

/**
 * @resource("User")
 */
class UserController extends PhalconRest\Mvc\Controller
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
    public function activate()
    {
        $user = $this->userService->activate();

        return $this->createItem($user, new UserTransformer, 'user');
    }

    /**
     * @title("Create")
     * @description("Create new user (register)")
     * @response("User object or Error object")
     * @requestExample({
     *      "name": "John Doe",
     *      "email": "john@doe.com",
     *      "account": {
     *          "username": "john",
     *          "password": "supersecretpassword"
     *      }
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
    public function create()
    {
        $data = $this->request->getJsonRawBody();

        $user = $this->userService->register($data);

        return $this->createItem($user, new UserTransformer, 'user');
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

        return $this->createItem($user, new UserTransformer, 'user');
    }

    /**
     * @title("Authenticate")
     * @description("Authenticate user")
     * @headers({
     *      "Authorization": "'Username sd9u19221934y=' (base64 encoded username and password) or 'Google dgd9u1243yndfs=' (base64 encoded code and access_token received from google client authentication)"
     * })
     * @response("Data object or Error object")
     * @responseExample({
     *      "data": {
     *          "AuthToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
     *          "Expires": 1428497770000
     *      }
     *  })
     */
    public function login()
    {

        $tokenData = $this->userService->login();

        return $this->respondWithArray($tokenData, 'data');

    }

}
