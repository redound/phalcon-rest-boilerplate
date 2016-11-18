<?php

namespace App\User;

use App\Constants\AclRoles;
use App\Model\User;

class Service extends \PhalconApi\User\Service
{
    protected $detailsCache = [];

    public function getRole()
    {
        /** @var User $userModel */
        $userModel = $this->getDetails();

        $role = AclRoles::UNAUTHORIZED;

        if($userModel && in_array($userModel->role, AclRoles::ALL_ROLES)){
            $role = $userModel->role;
        }

        return $role;
    }

    protected function getDetailsForIdentity($identity)
    {
        if (array_key_exists($identity, $this->detailsCache)) {
            return $this->detailsCache[$identity];
        }

        $details = User::findFirst((int)$identity);
        $this->detailsCache[$identity] = $details;

        return $details;
    }
}