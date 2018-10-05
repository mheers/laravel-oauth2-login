<?php

namespace Kronthto\LaravelOAuth2Login\Providers;

use Auth;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'oauth2login');
    }

    public function boot()
    {
        $this->publishes([__DIR__.'/../Config/config.php' => config_path('oauth2login.php')]);
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        Auth::extend(config('oauth2login.auth_driver_key'), function () {
            $guard = new RequestGuard(app(AuthFromRequest::class), $this->app['request']);

            $this->app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }
}
