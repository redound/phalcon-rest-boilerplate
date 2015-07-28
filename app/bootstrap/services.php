<?php

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\Services as PhalconRestServices;

$di = new \Phalcon\DI\FactoryDefault($config);

/**
 * @description Phalcon - \Phalcon\Config
 */
$di->setShared(AppServices::CONFIG, function () use ($config) {

    return $config;
});

/**
 * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
 */
$di->set(AppServices::DB, function () use ($config, $di) {

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name,
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($di->get(AppServices::EVENTS_MANAGER));

    return $connection;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Url
 */
$di->set(AppServices::URL, function () use ($config) {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * @description Phalcon - \Phalcon\Mvc\View\Simple
 */
$di->set(AppServices::VIEW, function () use ($config) {

    $view = new Phalcon\Mvc\View\Simple();
    $view->setViewsDir($config->application->viewsDir);

    return $view;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Router
 */
$di->set(AppServices::ROUTER, function () {

    return new \Phalcon\Mvc\Router;
});

/**
 * @description Phalcon - EventsManager
 */
$di->setShared(AppServices::EVENTS_MANAGER, function () use ($di, $config) {

    return new \Phalcon\Events\Manager;
});

/**
 * @description Phalcon - \Phalcon\Mvc\Model\Manager
 */
$di->setShared(AppServices::MODELS_MANAGER, function () use ($di) {

    $modelsManager = new \Phalcon\Mvc\Model\Manager;
    return $modelsManager->setEventsManager($di->get(AppServices::EVENTS_MANAGER));
});

/**
 * @description PhalconRest - \League\Fractal\Manager
 */
$di->setShared(PhalconRestServices::FRACTAL_MANAGER, function () {

    $fractal = new \League\Fractal\Manager;
    $fractal->setSerializer(new \Library\Fractal\CustomSerializer);
    return $fractal;
});

$di->setShared(PhalconRestServices::GOOGLE_CLIENT, function () use ($config) {

    $googleClient = new \PhalconRest\Facades\GoogleClient(new \Google_Client);

    return $googleClient
    ->setClientId($config->googleClient->clientId)
    ->setClientSecret($config->googleClient->clientSecret)
    ->setRedirectUri($config->googleClient->redirectUri)
    ->setScopes($config->googleClient->scopes);
});

/**
 * @description PhalconRest - \PhalconRest\Auth\Auth
 */
$di->setShared(PhalconRestServices::AUTH_MANAGER, function () use ($di, $config) {

    $sessionManager = new \PhalconRest\Auth\Session\JWT(new \JWT);
    $authManager = new \PhalconRest\Auth\Manager($sessionManager); // extended class

    // Setup Google Account Type
    // -----------------------------------

    // 1. Instantiate Google Client
    $googleClient = $di->get(PhalconRestServices::GOOGLE_CLIENT);

    // 2. Instantiate Google Account Type
    $authGoogle = new \PhalconRest\Auth\Account\Google(\Library\App\Constants\AccountTypes::GOOGLE);

    // 3. Set Google Client
    $authGoogle->setGoogleClient($googleClient);

    // 4. Set User Model
    $authGoogle->setUserModel(new \User);

    // Setup Username Account Type
    // -----------------------------------

    // 1. Instantiate Username Account Type
    $authUsername = new \PhalconRest\Auth\Account\Username(\Library\App\Constants\AccountTypes::USERNAME);

    // 2. Set User Model
    $authUsername->setUserModel(new \User);

    // 3. Set Email Account Model
    $authUsername->setUsernameAccountModel(new \UsernameAccount);

    // 4. Set Mail Service
    $authUsername->setMailService(AppServices::MAIL_SERVICE);

    // Setup Email Account Type
    // -----------------------------------

    // 1. Instantiate Email Account Type
    $authEmail = new \PhalconRest\Auth\Account\Email(\Library\App\Constants\AccountTypes::EMAIL);

    // 2. Set User Model
    $authEmail->setUserModel(new \User);

    // 3. Set Email Account Model
    $authEmail->setEmailAccountModel(new \EmailAccount);

    // 4. Set Mail Service
    $authEmail->setMailService(AppServices::MAIL_SERVICE);

    return $authManager
        ->addAccount(\Library\App\Constants\AccountTypes::GOOGLE, $authGoogle)
        ->addAccount(\Library\App\Constants\AccountTypes::USERNAME, $authUsername)
        ->addAccount(\Library\App\Constants\AccountTypes::EMAIL, $authEmail)
        ->setExpireTime($config->authentication->expireTime);
});

/**
 * @description PhalconRest - \PhalconRest\Mailer\Mailer
 */
$di->setShared(PhalconRestServices::MAILER, function () use ($di, $config) {

    //Create a new PHPMailer instance
    $mail = new \PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = $config->phpmailer->debugMode;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = $config->phpmailer->host;

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = $config->phpmailer->port;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = $config->phpmailer->smtpSecure;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = $config->phpmailer->smtpAuth;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $config->phpmailer->username;

    //Password to use for SMTP authentication
    $mail->Password = $config->phpmailer->password;

    //Set who the message is to be sent from
    $mail->setFrom($config->phpmailer->from->{0}, $config->phpmailer->from->{1});

    //Set an alternative reply-to address
    $mail->addReplyTo($config->phpmailer->replyTo->{0}, $config->phpmailer->replyTo->{1});

    //Set the subject line
    $mail->Subject = 'No subject';

    return new \PhalconRest\Mailer\Adapter\PhpMailer($mail);
});

/**
 * @description PhalconRest - \PhalconRest\Http\Request
 */
$di->setShared(PhalconRestServices::REQUEST, function () {

    return new \PhalconRest\Http\Request;
});

/**
 * @description PhalconRest - Response
 */
$di->set(PhalconRestServices::RESPONSE, function () use ($config) {

    $responseManager = new \PhalconRest\Http\Response\Manager($config->errorMessages->toArray());
    $response = new \PhalconRest\Http\Response;
    $response->setDebugMode($config->debugMode);
    return $response->setManager($responseManager);
});

/**
 * @description App - \Library\App\Services\UserService
 */
$di->setShared(AppServices::USER_SERVICE, function () {

    return new \Library\App\Services\UserService;
});

/**
 * @description App - \Library\App\Services\MailService
 */
$di->setShared(AppServices::MAIL_SERVICE, function () {

    return new \Library\App\Services\MailService;
});
