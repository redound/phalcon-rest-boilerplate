<?php

namespace App\Service;

use App\Auth\UsernameAccountType;
use PhalconRest\Constants\ErrorCodes;
use PhalconRest\Exception;

class UserService extends \PhalconRest\Mvc\Plugin
{
    protected $user = false;

    /**
     * @return \App\Model\User
     * @throws Exception
     */
    public function getUser()
    {
        if($this->user === false){

            $user = null;

            $session = $this->authManager->getSession();
            if($session){

                $identity = $session->getIdentity();
                $user = \App\Model\User::findFirst((int)$identity);
            }

            $this->user = $user;
        }

        return $this->user;
    }
}
