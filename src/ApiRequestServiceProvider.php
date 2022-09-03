<?php

namespace Pathum4u\ApiRequest;

use app;
use Illuminate\Support\ServiceProvider;

class ApiRequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $this->app->alias('ApiRequest', \Pathum4u\ApiRequest\ApiRequest::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
