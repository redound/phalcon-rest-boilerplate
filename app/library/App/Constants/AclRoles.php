<?php

namespace App\Constants;

class AclRoles
{
    const UNAUTHORIZED = 'unauthorized';
    const AUTHORIZED = 'authorized';
    const USER = 'user';
    const MANAGER = 'manager';
    const ADMINISTRATOR = 'administrator';

    const ALL_ROLES = [self::UNAUTHORIZED, self::AUTHORIZED, self::USER, self::MANAGER, self::ADMINISTRATOR];
}