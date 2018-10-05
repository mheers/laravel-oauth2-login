<?php

namespace Kronthto\LaravelOAuth2Login;

use League\OAuth2\Client\Provider\GenericProvider;

class OAuthProvider extends GenericProvider
{
    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
        if(substr($this->redirectUri, 0, 4)!=="http") {
            $this->redirectUri = route($this->redirectUri).config('oauth2login.oauth_redirect_path');
        }
    }
    protected function getDefaultHeaders()
    {
        return array_merge(parent::getDefaultHeaders(), [
            'Accept' => 'application/json',
            'User-Agent' => config('app.name', 'kronthto/laravel-oauth2-login'),
        ]);
    }
}
