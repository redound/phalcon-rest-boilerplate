<?php

return [

	'database' => [

		// Change to your own configuration
		'adapter'  => 'Mysql',
		'host'     => '127.0.0.1',
		'username' => 'root',
		'password' => 'root',
		'name'     => 'phalconrest',
	],

	/**
	 * @description - PhalconRest\Mailer\Adapter\PhpMailer Configuration
	 */
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
];