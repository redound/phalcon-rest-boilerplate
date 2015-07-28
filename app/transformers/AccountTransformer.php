<?php

use League\Fractal;

class AccountTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'email',
        'username',
        'google',
    ];

    public function transform($user)
    {
        // Only allow include when data present
        $this->defaultIncludes = [];

        // Include when username account is present
        if ($user->usernameAccount) {
            $this->defaultIncludes[] = 'username';
        }

        // Include when email account is present
        if ($user->emailAccount) {
            $this->defaultIncludes[] = 'email';
        }

        // Include when google account is present
        if ($user->googleAccount) {
            $this->defaultIncludes[] = 'google';
        }

        // Only include accounts
        return [];
    }

    public function includeUsername($user)
    {
        return $this->item($user->usernameAccount, new UsernameAccountTransformer, 'parent');
    }

    public function includeEmail($user)
    {
        return $this->item($user->emailAccount, new EmailAccountTransformer, 'parent');
    }

    public function includeGoogle($user)
    {
        return $this->item($user->googleAccount, new GoogleAccountTransformer, 'parent');
    }
}
