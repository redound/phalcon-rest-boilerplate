<?php

namespace App\Auth;

use App\Constants\Services;
use Phalcon\Di;
use PhalconRest\Auth\Manager;

class UsernameAccountType implements \PhalconRest\Auth\AccountType
{
    const NAME = "username";

    public function login($data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Services::SECURITY);

        $username = $data[Manager::LOGIN_DATA_USERNAME];
        $password = $data[Manager::LOGIN_DATA_PASSWORD];

        /** @var \User $user */
        $user = \User::findFirst([
            'conditions' => 'username = :username:',
            'bind' => ['username' => $username]
        ]);

        if(!$user){
            return null;
        }

        if(!$security->checkHash($password, $user->password)){
            return null;
        }

        return (string)$user->id;
    }

    public function authenticate($identity)
    {
        return \User::existsById((int)$identity);
    }
}