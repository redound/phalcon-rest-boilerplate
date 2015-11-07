<?php

return [

    'application' => [
        'baseUri' => '/',
        'viewsDir' => __DIR__ . '/../views/',
    ],

    'authentication' => [
        'secret' => 'this_should_be_changed',
        'expirationTime' => 86400 * 7, // One week till token expires
    ],
    'acl' => [
        'publicEndpoints' => [
            '/',
            '/proxy.html',
            '/export/documentation.json',
            '/export/postman.json',
            '/users',
            '/users/authenticate'
        ],
        'privateEndpoints' => [
            '/users/me',
            '/products',
            '/products/{product_id}',
        ],
    ]
];