<?php

return [

    'debug' => true,
    'hostName' => 'http://phalcon-rest-boilerplate.vagrantserver.com',
    'clientHostName' => 'http://phalcon-rest-app.vagrantserver.com',
    'database' => [

        // Change to your own configuration
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'name' => 'phalcon_rest_boilerplate',
    ],
    'cors' => [
        'allowedOrigins' => ['*']
    ]
];