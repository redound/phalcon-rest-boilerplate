<?php

namespace Library\App\Services;

use PhalconRest\Exceptions\UserException,
    PhalconRest\Exceptions\CoreException,
    Library\App\Constants\Services as AppServices,
    PhalconRest\Constants\Services as PhalconRestServices,
    PhalconRest\Constants\ErrorCodes as ErrorCodes;

class UserService extends \Phalcon\Mvc\User\Plugin {

    public function __construct()
    {
        $this->request          = $this->di->get(PhalconRestServices::REQUEST);
        $this->authManager      = $this->di->get(PhalconRestServices::AUTH_MANAGER);
        $this->mailService      = $this->di->get(AppServices::MAIL_SERVICE);
    }

    public function activate()
    {

        if (!$this->request->hasQuery('mailtoken')) {

            throw new UserException(ErrorCodes::GEN_NOTFOUND, 'You will need a mailtoken to activate');
        }

        $mailtoken = $this->request->getQuery('mailtoken');

        $user = \User::findFirst([
            'conditions' => 'mailToken = :mailtoken:',
            'bind' => ['mailtoken' => $mailtoken]
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

    public function register($data)
    {
        $db = $this->di->get(AppServices::DB);

        if (!isset($data->name) && !isset($data->email) || !isset($data->username) || !isset($data->password)) {

            throw new UserException(ErrorCodes::DATA_INVALID);
        }

        $user = \User::findFirstByEmail($data->email);

        // When user already exists with username account
        if ($user && $user->getAccount(\Library\App\Constants\AccountTypes::USERNAME)) {

            throw new UserException(ErrorCodes::DATA_DUPLICATE, 'User already exists.');
        }

        // Check if perhaps username already exists
        $usernameAccount = \UsernameAccount::findFirstByUsername($data->username);

        if ($usernameAccount){

            throw new \Exception('Username already exists');
        }

        // Let's create username account
        $usernameAccount                        = new \UsernameAccount();
        $usernameAccount->username              = $data->username;
        $usernameAccount->password              = $this->security->hash($data->password);

        // If user already exists, this stays false in the
        // next check so there will not be sent an activation mail.
        $sendActivationMail = false;

        // Here we start a transaction, because we are possibly executing
        // multiple queries. If one fails, we simply rollback all the queries
        // so there won't be any data inconsistency
        $db->begin();

        try {

            // If there's no user yet, first create one.
            if (!$user) {

                $sendActivationMail = true;

                $mailToken = $this->authManager->createMailToken();

                $user = new \User();
                $user->name             = $data->name;
                $user->email            = $data->email;

                // By default, user is not active.
                // They need to click the mailToken they get sent by mail
                $user->active           = 0;
                $user->mailToken        = $mailToken;
            }

            $user->usernameAccount  = $usernameAccount;

            if (!$user->save()) {

                throw new \Exception('User could not be registered.');
            }

            if ($sendActivationMail) {

                // Send a mail where they can activate their account
                $sent = $this->mailService->sendActivationMail($user, $usernameAccount);

                if (!$sent){

                    throw new \Exception('User #' . $user->id . ' was created, but Activation mail could not be sent. So changes have been rolled back.');
                }
            }

            // Everything has gone to plan, let's commit those changes!
            $db->commit();

        } catch(\Exception $e){

            $db->rollback();
            throw new UserException(ErrorCodes::USER_CREATEFAIL, $e->getMessage());
        }

        return $user;
    }

    public function me()
    {
        $user = $this->authManager->getUser();

        $user = \User::findFirst($user->id);

        if (!$user){

            throw new UserException(ErrorCodes::USER_NOTFOUND);
        }

        return $user;
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