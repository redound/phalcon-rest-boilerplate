<?php

namespace App\Bootstrap;

use App\Constants\Resources;
use App\Constants\Services;
use App\Model\Item;
use App\Model\Product;
use App\Model\User;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Acl\Helper;
use PhalconRest\Api;
use PhalconRest\Api\Resource;
use PhalconRest\Constants\AclRoles;
use PhalconRest\Constants\HttpMethods;

class AclBootstrap extends \App\Bootstrap
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        /** @var \Phalcon\Acl\Adapter $acl */
        $acl = $di->get(Services::ACL);

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        $acl->addRole(new Acl\Role(AclRoles::NONE));
        $acl->addRole(new Acl\Role(AclRoles::AUTHORIZED));
        $acl->addRole(new Acl\Role(AclRoles::ADMINISTRATOR));
        $acl->addRole(new Acl\Role(AclRoles::MANAGER));
        $acl->addRole(new Acl\Role(AclRoles::USER));

        /** @var \PhalconRest\Acl\Helper $aclHelper */
        $aclHelper = $di->get(Services::ACL_HELPER);

        $aclHelper->importManyApiResources($acl, $api->getResources());
    }
}