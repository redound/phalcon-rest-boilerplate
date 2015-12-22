<?php

namespace App\Transformer;

use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(\App\Model\User $user)
    {
        return [
            'id' => (int)$user->id,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
            'username' => $user->username
        ];
    }
}
