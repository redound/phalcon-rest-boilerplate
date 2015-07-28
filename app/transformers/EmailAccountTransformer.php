<?php

use League\Fractal;

class EmailAccountTransformer extends Fractal\TransformerAbstract
{
    public function transform($account)
    {
        return [
            'id' => (int) $account->id,
            'userId' => (int) $account->userId,
            'email' => $account->email,
        ];
    }
}