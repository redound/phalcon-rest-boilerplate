<?php

/**
 * Here we mount our collections
 */
$app->mount(new ExportCollection);
$app->mount(new ProductCollection);
$app->mount(new UserCollection);
