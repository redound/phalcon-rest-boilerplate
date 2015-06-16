<?php

return [

    'application' => [
        'baseUri' => '/',
        'viewsDir' => __DIR__ . '/../../app/views/',
    ],

    'activationMail' => [
        'subject' => 'Activate your account',
        'template' => 'mail/activation', // in views folder
    ],

    'xdomain' => [
        'route' => '/proxy.html',
        'viewPath' => 'general/proxy',
    ],

    'googleClient' => [
        'clientId' => 'your-google-client-id.apps.googleusercontent.com',
        'clientSecret' => 'your-client-secret',
        'redirectUri' => 'postmessage',
        'scopes' => 'https://www.googleapis.com/auth/userinfo.profile',
    ],

    'authentication' => [
        'jwtSecret' => 'example_key',
        'genSalt' => 'should-also-be-in-application-env',
        'expireTime' => 86400 * 7, // One week till token expires
    ],

    'acl' => [
        'publicEndpoints' => [
            '/proxy.html',
            '/export/documentation.json',
            '/export/postman-collection.json',
            '/users',
            '/users/authenticate/{account}',
            '/users/activate',
        ],
        'privateEndpoints' => [
            '/users/me',
            '/products',
            '/products/{product_id}',
        ],
    ],

    'errorMessages' => [

        // General
        1001 => [
            'statuscode' => 404,
            'message' => 'General: Not found',
        ],

        // Data
        2001 => [
            'statuscode' => 404,
            'message' => 'Data: Duplicate data',
        ],

        2002 => [
            'statuscode' => 404,
            'message' => 'Data: Not Found',
        ],

        2003 => [
            'statuscode' => 404,
            'message' => 'Failed to process data',
        ],

        2004 => [
            'statuscode' => 404,
            'message' => 'Data: Invalid',
        ],

        2005 => [
            'statuscode' => 404,
            'message' => 'Action failed',
        ],

        // Authentication
        3006 => [
            'statuscode' => 404,
            'message' => 'Auth: No authentication bearer present',
        ],

        3007 => [
            'statuscode' => 404,
            'message' => 'Auth: No username present',
        ],

        3008 => [
            'statuscode' => 404,
            'message' => 'Auth: Invalid authentication bearer type',
        ],

        3009 => [
            'statuscode' => 404,
            'message' => 'Auth: Bad login credentials',
        ],

        3010 => [
            'statuscode' => 401,
            'message' => 'Auth: Unauthorized',
        ],

        3020 => [
            'statuscode' => 403,
            'message' => 'Auth: Forbidden',
        ],

        4001 => [
            'statuscode' => 404,
            'message' => 'Google: No data',
        ],

        4002 => [
            'statuscode' => 404,
            'message' => 'Google: Bad login',
        ],

        4003 => [
            'statuscode' => 404,
            'message' => 'User: Not active',
        ],

        4004 => [
            'statuscode' => 404,
            'message' => 'User: Not found',
        ],

        4005 => [
            'statuscode' => 404,
            'message' => 'User: Registration failed',
        ],

        4006 => [
            'statuscode' => 404,
            'message' => 'User: Modification failed',
        ],

        4007 => [
            'statuscode' => 404,
            'message' => 'User: Creation failed',
        ],

        // PDO
        23000 => [
            'statuscode' => 404,
            'message' => 'Duplicate entry',
        ],
    ],
];
