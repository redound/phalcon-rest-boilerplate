<?php

class EmailAccount extends BaseModel
{

    public function getSource()
    {
        return 'email_account';
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
            'email' => 'email',
            'password' => 'password',
            'user_id' => 'userId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function validateRules()
    {
        return [
            'email' => 'min:6|max:55', // should be between 6 - 55 chars
        ];
    }

    public function validatePassword($password)
    {
        return $this->di->get('security')->checkHash($password, $this->password);
    }
}