<?php

use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(\User $user)
    {
        return [
            'id' => (int)$user->id,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
            'username' => $user->username
        ];
    }
}
