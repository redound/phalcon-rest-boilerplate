<?php

use PhalconRest\Exceptions\UserException;
use Library\PhalconRest\Constants\ErrorCodes as ErrorCodes;

class Product extends PhalconRest\Mvc\Model
{
	protected $_rules;

	public function getSource()
	{

		return 'product';
	}

	public function columnMap()
	{

	    return [
	        'id'                        => 'id',
	        'title'                     => 'title',
	        'brand'                    	=> 'brand',
	        'color'           			=> 'color',
	        'created_at' 	            => 'createdAt',
	        'updated_at' 	            => 'updatedAt',
	    ];
	}

	public function whitelist()
	{

		return [
			'title',
	        'brand',
	        'color'
		];
	}

	public function validateRules()
	{

		return [
			'title' => 'min:2|max:55|required',
			'brand' => 'min:2|max:55',
			'color' => 'min:2|max:6'
		];
	}
}
