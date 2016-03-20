<?php

namespace App\Bootstrap;

use App\BootstrapInterface;
use App\Collections\ExportCollection;
use App\Resources\UserResource;
use App\Resources\AlbumResource;
use App\Resources\PhotoResource;
use Phalcon\Acl;
use Phalcon\Config;
use Phalcon\DiInterface;
use PhalconRest\Api;

class CollectionBootstrap implements BootstrapInterface
{
    public function run(Api $api, DiInterface $di, Config $config)
    {
        $api
            ->collection(ExportCollection::factory('/export'))
            ->resource(UserResource::factory('/users'))
            ->resource(AlbumResource::crud('/albums'))
            ->resource(PhotoResource::crud('/photos'));
    }
}