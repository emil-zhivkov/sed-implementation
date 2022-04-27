<?php

namespace Zhivkov\SedImplementation;

use Illuminate\Support\ServiceProvider;
use Zhivkov\SedImplementation\Console\Sed;

class SedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Sed::class
                        ]);
    }
}
