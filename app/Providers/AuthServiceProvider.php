<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTAuth;
use Dingo\Api\Auth\Auth as DingoAuth;
use Dingo\Api\Auth\Provider\JWT as JWTProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    /**
		 * Service User Auth
		 */
	    $this->app->bind('AuthService', 'App\Services\AuthService');

	    $this->registerClassAlias();
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
	    $this->app->extend('api.auth', function (DingoAuth $auth) {
		    $auth->extend('jwt', function ($app) {
			    return new JWTProvider($app[JWTAuth::class]);
		    });
		    return $auth;
	    });
    }

    protected function registerClassAlias() {
	    class_alias(\Tymon\JWTAuth\Facades\JWTAuth::class, 'JWTAuth');
	    class_alias(\Tymon\JWTAuth\Facades\JWTFactory::class, 'JWTFactory');
    }
}
