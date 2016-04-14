<?php

namespace App\Auth;

use PhalconRest\Auth\Session;
use PhalconRest\Exception;

class Manager extends \PhalconRest\Auth\Manager
{
    const LOGIN_DATA_EMAIL = 'email';

    /**
     * @param string $accountTypeName
     * @param string $email
     * @param string $password
     *
     * @return Session Created session
     * @throws Exception
     *
     * Helper to login with email & password
     */
    public function loginWithEmailPassword($accountTypeName, $email, $password)
    {
        return $this->login($accountTypeName, [

            self::LOGIN_DATA_EMAIL => $email,
            self::LOGIN_DATA_PASSWORD => $password
        ]);
    }
}