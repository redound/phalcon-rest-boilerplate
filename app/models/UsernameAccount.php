<?php

class UsernameAccount extends BaseModel
{

    public function getSource()
    {
        return 'username_account';
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
            'username' => 'username',
            'password' => 'password',
            'user_id' => 'userId',
        ];
    }

    public function validateRules()
    {
        return [
            'username' => 'min:6|max:25', // should be between 6 - 25 chars
        ];
    }

    public function validatePassword($password)
    {
        return $this->di->get('security')->checkHash($password, $this->password);
    }
}
