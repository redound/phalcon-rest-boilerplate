<?php

namespace PhalconRest\Models;

class GoogleAccount extends \PhalconRest\Mvc\Model
{
    
    public function getSource()
    {

        return 'google_account';
    }

    public function columnMap()
    {

        //Keys are the real names in the table and
        //the values their names in the application
        return [
            'id'                        => 'id',
            'user_id'                   => 'userId',
            'google_id'                 => 'googleId',
            'email'                     => 'email'
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
