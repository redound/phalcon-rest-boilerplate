<?php

use League\Fractal;

class AccountsTransformer extends Fractal\TransformerAbstract
{

	public function transform($accounts)
	{
		return $accounts;
	}
}
