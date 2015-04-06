<?php

return new \Phalcon\Config([

	'database' => [

		// Change to your own configuration
		'adapter'  => 'Mysql',
		'host'     => '127.0.0.1',
		'username' => 'root',
		'password' => 'root',
		'name'     => 'phalconrest',
	],

	'application' => [

		'baseUri'        		=> '/',
		'controllersDir' 		=> __DIR__ . '/../../app/controllers/',
		'modelsDir'      		=> __DIR__ . '/../../app/models/',
		'collectionsDir'     	=> __DIR__ . '/../../app/collections/',
		'transformersDir'	 	=> __DIR__ . '/../../app/transformers/',
		'servicesDir'	 		=> __DIR__ . '/../../app/services/',
		'viewsDir'       		=> __DIR__ . '/../../app/views/',
	],

	'namespaces' => [
		'OA' => __DIR__ . '/../../vendor/olivierandriessen/phalcon-rest/OA'
	],

	'phalconRest' => [

		'jwtSecret' 		=> 'example_key',
		'genSalt' 			=> 'should-also-be-in-application-env',

		'phpmailer'			=> [
			'debugMode'			=> 0, // 0 = off, 1 = client messages, 2 = client and server messages
			'host'				=> 'smtp.gmail.com',
			'port'				=> 587,
			'smtpSecure'		=> 'tls',
			'smtpAuth'			=> true,
			'from'				=> ['your-email@example.com', 'Your Name'],
			'replyTo'			=> ['your-email@example.com', 'Your Name'],
			'username'			=> 'your-email@example.com',
			'password'			=> 'secret-password',
		],

		'activationMail' 	=> [
			'subject' 			=> 'Activate your account',
			'template' 			=> 'mail/activation' // in views folder
		],

		'google' 			=> [
			'clientId' 			=> 'your-google-client-id.apps.googleusercontent.com',
			'clientSecret' 		=> 'your-client-secret',
			'redirectUri' 		=> 'postmessage',
			'scopes'			=> 'https://www.googleapis.com/auth/userinfo.profile'
		],

		'collections' => [
			'UsersCollection',
			'ProductsCollection',
		],

		// Public endpoints
		'publicEndpoints'	=> ['/users', '/users/login', '/users/activate'],

		// Private endpoints
		'privateEndpoints'	=> ['/users/me', '/products', '/products/{product_id}']
	],
]);
