<?php

namespace App\Mvc;

use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Exceptions\UserException;
use PhalconRest\Validation\Validator;

class Model extends \Phalcon\Mvc\Model
{
    public $createdAt;
    public $updatedAt;

    /**
     * @var Validator
     */
    protected $validator;


    public function assign(array $data, $dataColumnMap = null, $whiteList = null)
    {
        return parent::assign($data, $dataColumnMap, $whiteList === null ? $this->whitelist() : $whiteList);
    }

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
        if (!$this->validator) {
            $this->validator = Validator::make($this, $this->validateRules());
        }

        return $this->validator;
    }

    public function validation()
    {
        $this->validator = $this->getValidator();
        return $this->validator->passes();
    }

    public function onValidationFails()
    {
        $message = null;

        if ($this->validator) {
            $message = $this->validator->getFirstMessage();
        }

        if ($messages = $this->getMessages()) {
            $message = $messages[0]->getMessage();
        }

        if (is_null($message)) {

            $message = 'Could not validate data';
        }

        throw new UserException(ErrorCodes::DATA_INVALID, $message);
    }


    public function whitelist()
    {
        return null;
    }

    public function validateRules()
    {
        return [];
    }


    public static function existsById($id)
    {
        return self::count(array(
            'id = ?0',
            'bind' => array($id)
        )) > 0;
    }
}