<?php

namespace Library\App\Services;

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Constants\Services as PhalconRestServices;
use PhalconRest\Exceptions\UserException;

class UserService extends \Phalcon\Mvc\User\Plugin
{

    public function __construct()
    {
        $this->request = $this->di->get(PhalconRestServices::REQUEST);
        $this->authManager = $this->di->get(PhalconRestServices::AUTH_MANAGER);
        $this->mailService = $this->di->get(AppServices::MAIL_SERVICE);
    }

    public function activate()
    {

        if (!$this->request->hasQuery('mailtoken')) {

            throw new UserException(ErrorCodes::GEN_NOTFOUND, 'You will need a mailtoken to activate');
        }

        $mailtoken = $this->request->getQuery('mailtoken');

        $user = \User::findFirst([
            'conditions' => 'mailToken = :mailtoken:',
            'bind' => ['mailtoken' => $mailtoken],
        ]);

        if (!$user) {

            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Could not activate, user not found');
        }

        // Activate user by resetting mailToken && setting active to 1
        $user->mailToken = null;
        $user->active = 1;

        if (!$user->save()) {

            throw new UserException(ErrorCodes::DATA_FAIL, 'User found, but could not activate.');
        }

        return $user;
    }

    public function register($account, $data)
    {
        return $this->authManager->register($account, $data);
    }

    public function update($account, $data)
    {
        return $this->authManager->update($account, $data);
    }

    public function me()
    {
        $user = $this->authManager->getUser();

        $user = \User::findFirst($user->id);

        if (!$user) {

            throw new UserException(ErrorCodes::USER_NOTFOUND);
        }

        return $user;
    }

    public function delete()
    {
        $user = $this->authManager->getUser();

        $user = \User::findFirst($user->id);

        if (!$user) {

            throw new UserException(ErrorCodes::USER_NOTFOUND);
        }

        if (!$deleted = $user->delete()) {
            
            throw new UserException(ErrorCodes::DATA_DELETE_FAIL);
        }

        return $deleted;
    }

    public function login($account)
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        if (is_null($username)) {

            throw new UserException(ErrorCodes::AUTH_NOUSERNAME);
        };

        if (!$this->authManager->login($account, $username, $password)) {

            throw new UserException(ErrorCodes::AUTH_BADLOGIN, 'Failed to login.');
        }

        return $this->authManager->getTokenResponse();
    }
}
