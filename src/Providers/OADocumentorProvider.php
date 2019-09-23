<?php

namespace OADocumentor\Providers;

use OADocumentor\Documentor;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
class OADocumentorProvider extends ServiceProvider {
    public function boot()
    {
        $this->app->bind('documentor', function() {
            return new Documentor(new Filesystem);
        });

        $this->publishes([
            __DIR__ . '/../config/documentor.php' => config_path('documentor.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/documentor.php',
            'documentor'
        );
    }
}