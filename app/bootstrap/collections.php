<?php

$app->mount(new ApiCollection);
$app->mount(new ExportCollection);
$app->mount(new ProductCollection);
$app->mount(new UserCollection);