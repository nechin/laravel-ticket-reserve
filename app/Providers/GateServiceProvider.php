<?php

namespace App\Providers;

use App\Services\Gates\Contracts\Gate;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Gate::class, function ($app) {
            $gateProvider = config('gate.provider');
            if ($gateProvider) {
                return new $gateProvider();
            }

            return null;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Gate::class];
    }
}
