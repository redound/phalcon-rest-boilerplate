<?php

$di = new \Phalcon\DI\FactoryDefault($config);

/** ---------------- PHALCON SERVICES --------------------- */

/**
 * @description Phalcon - \Phalcon\Config
 */
$di->setShared(PhalconServices::CONFIG, function() use ($config){

    return $config;
});

/**
 * @description Phalcon - \League\Fractal\Manager
 */
$di->set(PhalconServices::DB, function() use ($config, $di) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host"          => $config->database->host,
        "username"      => $config->database->username,
        "password"      => $config->database->password,
        "dbname"        => $config->database->name
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($di->get('eventsManager'));

    return $connection;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Url
 */
$di->set(PhalconServices::URL, function() use ($config) {
	$url = new \Phalcon\Mvc\Url();
	$url->setBaseUri($config->application->baseUri);
	return $url;
});

/**
 * @description Phalcon - \Phalcon\Mvc\View\Simple
 */
$di->set(PhalconServices::VIEW, function() use ($config) {

	$view = new Phalcon\Mvc\View\Simple();
	$view->setViewsDir($config->application->viewsDir);

	return $view;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Router
 */
$di->set(PhalconServices::ROUTER, function(){

    return new \Phalcon\Mvc\Router;
});

/**
 * @description Phalcon - EventsManager
 */
$di->setShared(PhalconServices::EVENTS_MANAGER, function(){

    // Create instance
    $eventsManager = new \Phalcon\Events\Manager;

    /**
     * @description PhalconRest - Authenticate user
     */
    $eventsManager->attach('micro', new \PhalconRest\Middleware\Authentication);

    /**
     * @description PhalconRest - Authorize endpoints
     */
    $eventsManager->attach('micro', new \PhalconRest\Middleware\Acl);

    return $eventsManager;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Model\Manager
 */
$di->setShared(PhalconServices::MODELS_MANAGER, function() use ($di){

    $modelsManager = new \Phalcon\Mvc\Model\Manager;
    return $modelsManager->setEventsManager($di->get(PhalconServices::EVENTS_MANAGER));
});

/** ---------------- FRACTAL SERVICES --------------------- */

/**
 * @description Fractal - \League\Fractal\Manager
 */
$di->set(FractalServices::MANAGER, function(){

    $fractal = new \League\Fractal\Manager;
    $fractal->setSerializer(new \Library\Fractal\CustomSerializer);
    return $fractal;
});

/** ---------------- PHALCON REST SERVICES --------------------- */

/**
 * @description PhalconRest - \PhalconRest\Auth\Auth
 */
$di->setShared(PhalconRestServices::AUTH, function(){

    return new \PhalconRest\Auth\Auth;
});

/**
 * @description PhalconRest - \PhalconRest\Mailer\Mailer
 */
$di->setShared(PhalconRestServices::MAILER, function(){

    $di->get(PhalconServices::CONFIG)->phpmailer;

    //Create a new PHPMailer instance
    $mail = new \PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = $phpmailer->debugMode;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = $phpmailer->host;

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = $phpmailer->port;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = $phpmailer->smtpSecure;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = $phpmailer->smtpAuth;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $phpmailer->username;

    //Password to use for SMTP authentication
    $mail->Password = $phpmailer->password;

    //Set who the message is to be sent from
    $mail->setFrom($phpmailer->from[0], $phpmailer->from[1]);

    //Set an alternative reply-to address
    $mail->addReplyTo($phpmailer->replyTo[0], $phpmailer->replyTo[1]);

    //Set the subject line
    $mail->Subject = 'No subject';

    $adapter = new \PhalconRest\Mailer\Adapter\PhpMailer($mail);
    return new \PhalconRest\Mailer\Mailer($adapter);
});

/**
 * @description PhalconRest - \PhalconRest\Http\Request
 */
$di->setShared(PhalconRestServices::REQUEST, function(){

    return new \PhalconRest\Http\Request;
});

/**
 * @description PhalconRest - Response
 */
$di->set(PhalconRestServices::RESPONSE, function(){

    return new \PhalconRest\Http\Response;
});

/**
 * @description PhalconRest - Response
 */
$di->set(PhalconRestServices::RESPONSE, function() use ($config) {

    $responseManager = new \PhalconRest\Http\Response\Manager;
    return $responseManager->setMessages($config->errorMessages);
});