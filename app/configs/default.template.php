<?php

/**
 * Read more on Config Files
 * @link http://phalcon-rest.redound.org/config_files.html
 */

return [

    'application' => [
        'title' => 'Phalcon REST Boilerplate',
        'description' => 'This repository provides an boilerplate application with all of the classes of Phalcon REST library implemented.',
        'baseUri' => '/',
        'viewsDir' => __DIR__ . '/../views/',
    ],

    'authentication' => [
        'secret' => 'this_should_be_changed',
        'expirationTime' => 86400 * 7, // One week till token expires
    ]
];
