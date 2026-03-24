<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ApiResponse;

class ApiResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('apiResponse', function () {
            return new ApiResponse();
        });
    }

    public function boot()
    {
        //
    }
}
