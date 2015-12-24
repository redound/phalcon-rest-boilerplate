<?php

namespace App\Model;

class User extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $role;
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
        return parent::columnMap() + [
            'id' => 'id',
            'role' => 'role',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'username' => 'username',
            'password' => 'password'
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