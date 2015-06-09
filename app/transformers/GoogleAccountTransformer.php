<?php

use League\Fractal;

class GoogleAccountTransformer extends Fractal\TransformerAbstract
{
	public function transform($google)
	{
		return [
			'id' 				=> (int) $google->id,
			'userId' 			=> (int) $google->userId,
			'googleId' 			=> (int) $google->googleId,
			'email' 			=> $google->email
		];
	}
}
