<?php

namespace Tongwoojun\OAuth\Providers;

use Tongwoojun\OAuth\Provider;
use Flarum\Forum\Auth\Registration;
use League\OAuth2\Client\Provider\AbstractProvider;
use Tongwoojun\OAuth2\Client\Provider\IQiYi as IQiYiProvider;


class IQiYi extends Provider
{
    public function name(): string
    {
        return 'iqiyi';
    }

    public function link(): string
    {
        return 'https://www.iqiyi.com';
    }

    public function fields(): array
    {
        return [
            'api_key'    => 'required',
            'api_secret' => 'required',
        ];
    }

    public function provider(string $redirectUri): AbstractProvider
    {
        return new IQiYiProvider([
            'clientId'                => $this->getSetting('api_key'),
            'clientSecret'            => $this->getSetting('api_secret'),
            'redirectUri'             => $redirectUri
        ]);
    }

    public function suggestions(Registration $registration, $user, string $token)
    {
        $this->verifyEmail($email = $user->getEmail());

        $registration
        ->provideTrustedEmail($email)
        ->suggestUsername($user->getNickName())
        ->provideAvatar($user->getUserIcon())
        ->setPayload($user->toArray());
    }
}
