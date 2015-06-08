<?php

namespace PhalconRest\Transformers;

use League\Fractal;
use PhalconRest\Constants\AccountTypes;

class AccountsTransformer extends Fractal\TransformerAbstract
{

	public function transform($accounts)
	{
		return $accounts;
	}
}
