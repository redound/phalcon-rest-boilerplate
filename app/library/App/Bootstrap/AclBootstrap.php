<?php

namespace App\Bootstrap;

use App\Constants\Services;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;
use App\Constants\AclRoles;

class AclBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        /** @var \Phalcon\Acl\Adapter $acl */
        $acl = $di->get(Services::ACL);

        $acl->addRole(new Acl\Role(AclRoles::UNAUTHORIZED));
        $acl->addRole(new Acl\Role(AclRoles::AUTHORIZED));
        $acl->addRole(new Acl\Role(AclRoles::ADMINISTRATOR));
        $acl->addRole(new Acl\Role(AclRoles::MANAGER));
        $acl->addRole(new Acl\Role(AclRoles::USER));

        /** @var \PhalconRest\Acl\Helper $aclHelper */
        $aclHelper = $di->get(Services::ACL_HELPER);

        $aclHelper->importManyApiResources($acl, $api->getResources());
    }
}