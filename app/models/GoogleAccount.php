<?php

class GoogleAccount extends BaseModel
{

    public function getSource()
    {
        return 'google_account';
    }

    public function initialize()
    {
        $this->hasOne('userId', 'User', 'id', [
            'alias' => 'User',
        ]);
    }

    public function columnMap()
    {
        return [
            'id' => 'id',
            'user_id' => 'userId',
            'google_id' => 'googleId',
            'email' => 'email',
        ];
    }

    public function validateRules()
    {
        return [
            'email' => 'email', // should be an e-mailaddress
            'googleId' => 'pattern:/\d{21}/', // should be exactly 21 digits
        ];
    }
}
