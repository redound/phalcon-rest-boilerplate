<?php

namespace App\Constants;

class AclRoles
{
    const UNAUTHORIZED = 'Unauthorized';
    const AUTHORIZED = 'Authorized';
    const USER = 'User';
    const MANAGER = 'Manager';
    const ADMINISTRATOR = 'Administrator';

    const ALL_ROLES = [self::UNAUTHORIZED, self::AUTHORIZED, self::USER, self::MANAGER, self::ADMINISTRATOR];
}