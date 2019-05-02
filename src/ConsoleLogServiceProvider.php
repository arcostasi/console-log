<?php

namespace Arcostasi\ConsoleLog;

use Arcostasi\ConsoleLog\Helpers\Console;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class ConsoleLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Nothing
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('console', function()
        {
            return new Console;
        });
    }
}
