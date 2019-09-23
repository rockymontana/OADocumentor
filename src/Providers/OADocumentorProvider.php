<?php

namespace OADocumentor\Providers;

use OADocumentor\Documentor;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use OADocumentor\Console\Commands\GenerateDocumentationCommand;

class OADocumentorProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->bind('documentor', function() {
            return new Documentor(new Filesystem);
        });

        $this->publishes([
            __DIR__ . '/../config/documentor.php' => config_path('documentor.php'),
            __DIR__ . '/../config/openapi.php' => config_path('openapi.php'),
        ]);

        if (config('documentor.redoc.enable')) {
            $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'OADocumentor');
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocumentationCommand::class,
            ]);
        }
    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/documentor.php',
            'documentor'
        );
    }
}