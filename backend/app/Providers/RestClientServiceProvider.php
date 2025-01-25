<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RestClient\RestClient;
use App\Services\RestClient\RestClientInterface;

class RestClientServiceProvider extends ServiceProvider
{

    public function register() {}

    public function boot()
    {
        $this->app->bind(RestClientInterface::class, function () {});
    }
}
