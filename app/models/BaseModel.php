<?php

use PhalconRest\Validation\Validator,
	PhalconRest\Exceptions\CoreException,
	PhalconRest\Exceptions\UserException,
	PhalconRest\Constants\ErrorCodes as ErrorCodes;

class BaseModel extends \Phalcon\Mvc\Model
{
	protected $validator;

	public function beforeValidationOnCreate()
	{
		$this->createdAt = date('Y-m-d H:i:s');
		$this->updatedAt = date('Y-m-d H:i:s');
	}

	public function beforeValidationOnUpdate()
	{
		$this->updatedAt = date('Y-m-d H:i:s');
	}

	public function getValidator()
	{
		if (!$this->validator){


			$this->validator = Validator::make($this, $this->validateRules());
		}

		return $this->validator;
	}

	public function validation()
	{
		if (!method_exists($this, 'validateRules')){
			return true;
		}

		$this->validator = $this->getValidator();

		return $this->validator->passes();
	}

	public function onValidationFails()
	{
		$message = null;
		if ($this->validator)
		{
			$message = $this->validator->getFirstMessage();
		}

		if ($messages = $this->getMessages())
		{
			$message = $messages[0]->getMessage();
		}

		if (is_null($message)){

			$message = 'Could not validate data';
		}

		throw new UserException(ErrorCodes::DATA_INVALID, $message);
	}

	public function prepare($data)
	{

		$whitelist = $this->whitelist();

		foreach ($whitelist as $field){
			if (isset($data->$field)) {
				$this->$field = $data->$field;
			}
		}
	}

	public static function createFrom($data)
	{
		$modelName = get_called_class();
		$modelInstance = new $modelName;

		if (!isset($modelInstance->_whitelist)) {
			throw new CoreException('No whitelist declared for: ' . $modelName);
		}

	}

	public static function exists($id)
	{
		return self::findFirstById($id);
	}

	public static function remove($opts)
	{
		$result = self::findFirst($opts);

		if (!$result) {
			return false;
		}

		return $result->delete();
	}
}