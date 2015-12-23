<?php

namespace App\Model;

class User extends \App\Mvc\Model
{
    use \App\Mvc\Model\DateTrait;

    public $id;
    public $firstName;
    public $lastName;
    public $username;
    public $password;

    public function getSource()
    {
        return 'users';
    }

    public function columnMap()
    {
        return [
            'id' => 'id',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'username' => 'username',
            'password' => 'password',
            'updated_at' => 'updatedAt',
            'created_at' => 'createdAt',
        ];
    }

    public function whitelist()
    {
        return [
            'firstName',
            'lastName',
            'password'
        ];
    }
}