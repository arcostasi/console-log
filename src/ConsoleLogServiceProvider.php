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
        $this->publishConfig();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        App::bind('console', function()
        {
            return new Console;
        });
    }

    private function mergeConfig()
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'console');
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('console.php')], 'config');
    }

    private function getConfigPath()
    {
        return __DIR__ . '/config/console.php';
    }
}
