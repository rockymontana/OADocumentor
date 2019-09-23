<?php

namespace OADocumentor\Console\Commands;

use Illuminate\Console\Command;
use OADocumentor\Documentor;

class GenerateDocumentationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openapi:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and publish openapi documentation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            /** @var \OADocumentor\Documentor */
            $openapi = app()->make('documentor');
            $openapi->generate()
                ->validate()
                ->save();
        } catch (\OADocumentor\Exceptions\DocumentationValidationException $e) {
            $this->error($e->getMessage());
        }

        if (!file_exists(config('documentor.save.path') . '/index.html') && config('documentor.redoc') === true) {
            $this->publishRedoc();
        }

        $this->info('Your documentation is now generated.');

        if (config('documentor.redoc') === true) {
            $this->info('Visit ' . config('app.url') . '/docs to view it');
        }
    }

    public function publishRedoc() {

    }
}
