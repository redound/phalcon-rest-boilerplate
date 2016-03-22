<?php

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
    ],
    'debug' => true,
    'hostName' => 'http://phalcon-rest-boilerplate.redound.dev',
    'clientHostName' => 'http://phalcon-rest-boilerplate.redound.dev',
    'database' => [
        // Change to your own configuration
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'name' => 'phalcon_rest_boilerplate',
    ],
    'cors' => [
        'allowedOrigins' => ['phalcon-rest-boilerplate.dev']
    ]
];
