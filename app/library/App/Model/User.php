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
        return 'user';
    }

    public function columnMap()
    {
        return parent::columnMap() + [
            'id' => 'id',
            'role' => 'role',
            'email' => 'email',
            'username' => 'username',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'location' => 'location',
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