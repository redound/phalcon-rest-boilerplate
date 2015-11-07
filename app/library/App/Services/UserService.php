<?php

namespace App\Services;

use App\Auth\UsernameAccountType;
use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Exceptions\UserException;

class UserService extends \PhalconRest\Mvc\Plugin
{
    protected $user = false;

    /**
     * @return \User
     * @throws UserException
     */
    public function getUser()
    {
        if($this->user === false){

            $user = null;

            $session = $this->authManager->getSession();
            if($session){

                $identity = $session->getIdentity();
                $user = \User::findFirst((int)$identity);
            }

            $this->user = $user;
        }

        return $this->user;
    }
}
