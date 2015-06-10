<?php

use PhalconRest\Exceptions\CoreException;

class User extends BaseModel
{

    public function getSource()
    {
        return 'user';
    }

    public function columnMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'active' => 'active',
            'mail_token' => 'mailToken',
            'updated_at' => 'updatedAt',
            'created_at' => 'createdAt',
        ];
    }

    public function initialize()
    {
        $this->hasOne('id', 'GoogleAccount', 'userId', [
            'alias' => 'GoogleAccount',
        ]);

        $this->hasOne('id', 'UsernameAccount', 'userId', [
            'alias' => 'UsernameAccount',
        ]);
    }

    public function validateRules()
    {
        return [
            'name' => 'pattern:/[A-Za-z ]{0,55}/', // should contain between 0 - 55 letters
            'email' => 'email', // should be an email address
        ];
    }

    public function getAccount($account)
    {
        if ($account === \Library\App\Constants\AccountTypes::GOOGLE) {
            return $this->googleAccount;
        } elseif ($account === \Library\App\Constants\AccountTypes::USERNAME) {
            return $this->usernameAccount;
        }

        return false;
    }

    public static function findByPayload($payload)
    {
        return User::findFirstByEmail($payload['email']);
    }

    public function getByUsername($username)
    {
        return UsernameAccount::findFirstByUsername($username);
    }

    public function processGooglePayload($data)
    {
        $user = User::findByPayload($data);

        if ($user && $user->googleAccount) {
            return $user;
        }

        // Create Google Account
        $googleAccount = new \GoogleAccount;
        $googleAccount->googleId = $data['googleId'];
        $googleAccount->email = $data['email'];

        // No user? Create one
        if (!$user) {
            $user = new User;
            $user->email = $data['email'];
            $user->active = 1;
            $user->mailToken = null;
        }

        // Assign Google Account to User
        $user->googleAccount = $googleAccount;

        if (!$user->save()) {
            throw new CoreException(ErrorCodes::USER_REGISTERFAIL, 'User could not be created');
        }

        return $user;
    }
}
