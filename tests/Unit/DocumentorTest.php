<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OADocumentor\Documentor;
use Tests\TestCase;

class DocumentorTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        config(['documentor.directories.paths' => base_path('tests/docs/paths')]);
        config(['documentor.directories.components' => base_path('tests/docs/components')]);
    }

    /** @test */
    public function documentation_files_are_being_merged_into_a_collection()
    {
        /** @var $documentor OADocumentor\Documentor */
        $documentor = $this->app->make('documentor');
        $documentor->generate();
        $this->assertTrue($documentor->validate());
    }
}
