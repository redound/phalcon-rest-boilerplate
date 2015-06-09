<?php

namespace Library\App\Services;

use Library\App\Constants\Services as AppServices;
use PhalconRest\Constants\Services as PhalconRestServices;

class MailService extends \Phalcon\Mvc\User\Plugin
{

	public function sendActivationMail($user, $account)
	{
		$config 	= $this->di->get(AppServices::CONFIG);
		$view 		= $this->di->get(AppServices::VIEW);
		$mailer 	= $this->di->get(PhalconRestServices::MAILER);
		$link		= $config->clientHostName . '/activate?mailtoken=' . $user->mailToken;
		
		$mailer->setSubject($config->activationMail->subject);
		$mailer->addAddress($user->email, $user->name);

		// Render mail template
		$view->setVar('link', $link);
		$view->setVar('user', $user);
		$view->setVar('account', $account);
		$renderedView = $view->render($config->activationMail->template);

		// Add template to mail body
		$mailer->setHtmlBody($renderedView);

		return $mailer->send();
	}
}