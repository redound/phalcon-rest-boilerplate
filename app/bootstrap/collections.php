<?php

$app->mount(new \PhalconRest\Collection\ResourceCollection);
$app->mount(new ExportCollection);
$app->mount(new ProductCollection);
$app->mount(new UserCollection);